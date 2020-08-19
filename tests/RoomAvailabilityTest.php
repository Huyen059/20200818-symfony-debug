<?php
declare(strict_types=1);
namespace App\Tests;
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

use PHPUnit\Framework\TestCase;



class RoomAvailabilityTest extends TestCase
{
    public function testSum()
    {
        $a = 1;
        $b = 2;
        $c = 3;
        self::assertEquals($c, ($a + $b));
    }
}
