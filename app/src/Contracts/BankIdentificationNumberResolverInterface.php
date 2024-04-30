<?php

namespace Application\Contracts;

interface BankIdentificationNumberResolverInterface
{
    /**
     * Resolver will provide country code depends on 6-8 first card number.
     *
     * @param string $binNumbers six or eight numbers. Begging of card number
     * @return string country code in alpha2 format
     */
    public function check(string $binNumbers) : string;
}
