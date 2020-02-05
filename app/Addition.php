<?php


namespace App;


class Addition implements Operation
{

    public function run($num, $current)
    {
        return $current + $num;
    }
}