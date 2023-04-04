<?php
namespace App\Command;

use Brick\Money\Money;
use App\Entity\Product;
use App\Entity\RegionTax;
use Brick\Math\BigDecimal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:initialize-demo',
    description: 'Initializes demo database records',
    hidden: false
)]
class InitializeDemoCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->em->persist(new Product(
            'Наушники', 
            Money::of(100, 'EUR')
        ));
        $this->em->persist(new Product(
            'Чехол для телефона', 
            Money::of(20, 'EUR')
        ));
        $this->em->persist(new Product(
            'Что-то дробное', 
            Money::of('3.99', 'EUR')
        ));
        $this->em->persist(new Product(
            'Что-то дешевое', 
            Money::of('0.01', 'EUR')
        ));
        $this->em->persist(new Product(
            'Что-то дорогое', 
            Money::of('100000', 'EUR')
        ));

        $this->em->persist(new RegionTax(
            'de', 
            'DEXXXXXXXXX',
            BigDecimal::of('0.19')
        ));
        $this->em->persist(new RegionTax(
            'it', 
            'ITXXXXXXXXXXX',
            BigDecimal::of('0.22')
        ));
        $this->em->persist(new RegionTax(
            'gr', 
            'GRXXXXXXXXX',
            BigDecimal::of('0.24')
        ));

        $this->em->flush();

        $output->writeln('Done!');

        return 0;
    }
}