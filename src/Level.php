<?php

namespace App;

class Level 
{
    public static function calculate(int $exp): int
    {
        return floor($exp / 1000);
    }
}