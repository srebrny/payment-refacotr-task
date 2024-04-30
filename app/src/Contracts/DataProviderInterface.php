<?php

namespace Application\Contracts;

/**
 * DataProviderInterface add support to handle multiple way of getting data like files, database etc.
 */
interface DataProviderInterface
{
    public function load(): int;
    public function getData(): ?array;
}
