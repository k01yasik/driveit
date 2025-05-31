<?php

namespace App\Dto;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class NewsCollection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    public function __construct(
        private array $items = []
    ) {
    }

    // Implement all required interface methods
    // ... (методы для работы с коллекцией)
    
    public function toArray(): array
    {
        return $this->items;
    }
}
