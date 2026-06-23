<?php
class MathUtils
{
    private static $total = 0;
    public static function add($a , $b)
    {
        self::$total=$a + $b;
        // return self::$total;
    }
    public static function getTotal()
    {
        return self::$total;
    }
}
echo MathUtils::add(10 , 20);
echo MathUtils::getTotal();