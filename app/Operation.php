<?php


namespace App;


interface Operation
{
    public function run($num, $current);
}