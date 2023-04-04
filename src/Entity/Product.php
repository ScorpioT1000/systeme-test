<?php
namespace App\Entity;

use Brick\Money\Money;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private int $targetPriceMinor;

    #[ORM\Column]
    private string $targetCurrency;

    public function __construct(string $name, Money $targetPrice)
    {
        $this->name = $name;
        $this->setTargetPrice($targetPrice);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            // Original prices are hidden from client
            //'targetPrice' => (string)$this->getTargetPrice()->getAmount(),
            //'targetCurrency' => $this->getTargetPrice()->getCurrency()->getCurrencyCode()
        ];
    }

    /**
     * @return int 
     */
    public function getId(): int
    {
        return $this->id; 
    }

    /**
     * @return string 
     */
    public function getName(): string
    {
        return $this->name; 
    }

    /**
     * @param string $value 
     * @return static
     */
    public function setName(string $value)
    {
        $this->name = $value;

        return $this;
    }

    public function getTargetPrice(): Money
    {
        return Money::ofMinor($this->targetPriceMinor, $this->targetCurrency);
    }

    public function setTargetPrice(Money $price): self
    {
        $this->targetPriceMinor = (string)$price->getMinorAmount()->toInt();
        $this->targetCurrency = $price->getCurrency()->getCurrencyCode();
        return $this;
    }
}
