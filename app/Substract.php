<?php


namespace App;


class Substract implements Operation
{

    public function run($num, $current)
    {
        return $current - $num;
    }
}