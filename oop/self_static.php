<?php

use Dom\ChildNode;

class ParentClass
{
    public static function who()
    {
        echo "ParentClass \n";
    }
    public static function testSelf() 
    {
        self::who();    
    }
    public static function testStatic()
    {
        static::who();
    }

}
class ChildClass extends ParentClass
{
    public static function who()
    {
        echo "ChildClass \n";
    }
}
ChildClass::testSelf();
ChildClass::testStatic();