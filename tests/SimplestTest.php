<?php


namespace App\Tests;


use PHPUnit\Framework\TestCase;

class SimplestTest extends TestCase
{
    public function testAddition()
    {
        $value = true;
        $this->assertEquals(5,2+3, 'Five was expected to equal 2+3');
        $this->assertTrue($value);
    }
}