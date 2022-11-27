<?php

namespace App\Helpers;

class Math
{

    public static function add(...$nilai): int|float
    {
        return array_reduce($nilai, function ($carry, $item) {

            if (is_string($item)) {
                throw new \Error("add function not support string parameter");
            }

            return $carry + $item;
        });
    }
}
