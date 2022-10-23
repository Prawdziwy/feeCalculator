<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;
use PragmaGoTech\Interview\FeeCalculator;

/**
 * A cut down version of a loan application containing
 * only the required properties for this test.
 */
class Calculator implements FeeCalculator
{
    // Array of values
    private $amountTooFee = array(
        1000 => 50,
        2000 => 90,
        3000 => 90,
        4000 => 115,
        5000 => 100,
        6000 => 120,
        7000 => 140,
        8000 => 160,
        9000 => 180,
        10000 => 200,
        11000 => 220,
        12000 => 240,
        13000 => 260,
        14000 => 280,
        15000 => 300,
        16000 => 320,
        17000 => 340,
        18000 => 360,
        19000 => 380,
        20000 => 400
    );

    public function calculate(LoanProposal $application) : float {
        // Get closest thousand to amount declared
        $closestAmount = round($application->amount(), -3);

        // Get smaller or bigger thousand depends where rounding
        $secondClosestAmount = $application->amount() <= $closestAmount ? $closestAmount-1000 : $closestAmount+1000;

        // Get smaller and bigger Value of Loan Amounts
        $smallerValue = min($closestAmount, $secondClosestAmount);
        $biggerValue = max($closestAmount, $secondClosestAmount);

        // Get Fee from Amount of Loan
        $biggerFee = $this->amountTooFee[$biggerValue];
        $smallerFee = $this->amountTooFee[$smallerValue] ?? $biggerFee;

        // Calculate the Interpolated Value
        $valueRange = ($application->amount() - $smallerValue) / ($biggerValue - $smallerValue);
        $interpolatedValue = $smallerFee * (1 - $valueRange) + $biggerFee * $valueRange;

        // Return calculated value
        return round($interpolatedValue);
    }
}
