<?php


namespace App\Services\SortService\Interfaces;


interface Sort
{
    public function sort(array $posts): array;
}