<?php
namespace App\Entity;

use Brick\Math\BigDecimal;
use Brick\Money\Money;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RegionTax
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private string $regionCode;

    #[ORM\Column]
    private string $taxNumberMask;

    #[ORM\Column]
    private string $vatTax;

    public function __construct(string $regionCode, string $taxNumberMask, BigDecimal $vatTax)
    {
        $this->regionCode = $regionCode;
        $this->taxNumberMask = $taxNumberMask;
        $this->setVatTax($vatTax);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->getId(),
            'regionCode' => $this->getRegionCode(),
            'taxNumberMask' => $this->getTaxNumberMask(),
            'vatTax' => (string)$this->getVatTax()
        ];
    }

    public function getId(): int
    {
        return $this->id; 
    }

    /**
     * @return string 2-symbol code
     */
    public function getRegionCode(): string
    {
        return $this->regionCode; 
    }

    /**
     * @param string $value 2-symbol code
     * @return RegionTax 
     */
    public function setRegionCode(string $value): self
    {
        $this->regionCode = $value;

        return $this;
    }

    /**
     * @return string e.g. 'DEXXXXXXXXX'
     */
    public function getTaxNumberMask(): string
    {
        return $this->taxNumberMask; 
    }

    /**
     * @param string $value e.g. 'DEXXXXXXXXX'
     * @return static
     */
    public function setTaxNumberMask(string $value)
    {
        $this->taxNumberMask = $value;

        return $this;
    }

    /**
     * @return BigDecimal Absolute number like 0.15
     */
    public function getVatTax(): BigDecimal
    {
        return BigDecimal::of($this->vatTax); 
    }

    /**
     * @param BigDecimal $value Absolute number like 0.15
     * @return RegionTax 
     */
    public function setVatTax(BigDecimal $value): self
    {
        $this->vatTax = (string)$value;

        return $this;
    }
}
