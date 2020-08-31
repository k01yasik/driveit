<?php

namespace App\Repositories\Interfaces;


interface NewsRepositoryInterface
{
    public function getLastNews(): array;
}