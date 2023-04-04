<?php
namespace App\Service;

use App\Repository\RegionTaxRepository;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Brick\Money\Money;

class TaxCalculator
{
    public function calculateVatTax(Money $amount, BigDecimal $tax): Money
    {
        return $amount->isPositive() 
            ? $amount->multipliedBy($tax, RoundingMode::UP) 
            : Money::zero($amount->getCurrency());
    }

    /**
     * 
     * @param string $taxNumber e.g. 'DE123456789'
     * @return string Region code e.g. 'de'
     */
    public function getTaxRegionFromTaxNumber(string $taxNumber): string
    {
        return strtolower(substr($taxNumber, 0, 2));
    }
}