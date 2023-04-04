<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ErrorConverter;
use App\Service\TaxCalculator;
use App\Repository\ProductRepository;
use Symfony\Component\Form\FormError;
use App\Form\Type\ProductSelectorType;
use App\Repository\RegionTaxRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    #[Route('/load-all')]
    public function loadAll(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        return new JsonResponse([
            'products' => array_map(fn(Product $p) => $p->toPrimitives(), $products)
        ]);
    }

    #[Route('/get-amount/{product}')]
    public function getAmount(
        ?Product $product, 
        Request $request,
        FormFactoryInterface $formFactory,
        RegionTaxRepository $regionTaxRepository, 
        TaxCalculator $taxCalculator
    ): JsonResponse {
        $form = $formFactory->createNamed('form', ProductSelectorType::class);
        if(!$product) {
            return new JsonResponse(['error' => 'Unknown product requested'], 404);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fd = $form->getData();
            $regionCode = $taxCalculator->getTaxRegionFromTaxNumber($fd['taxNumber']);
            $regionTax = $regionTaxRepository->findOneBy(['regionCode' => $regionCode]);

            if(!$regionTax) {
                return new JsonResponse(['error' => 'Your tax region is not currently supported: '.$regionCode]);
            }
            $amount = $taxCalculator->calculateVatTax(
                $product->getTargetPrice(),
                $regionTax->getVatTax()
            )->plus($product->getTargetPrice());

            return new JsonResponse([
                'amount' => $amount->getAmount(), 
                'amountCurrency' => $amount->getCurrency()->getCurrencyCode()
            ]);
        } else {
            return new JsonResponse([
                'formErrors' => ErrorConverter::toPrimitives($form)
            ]);
        }

        return new JsonResponse(['error' => 'No form sent'], 400);
    }
}