<?php
declare(strict_types=1);
namespace App\Tests;
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CheckCreditTest extends TestCase
{
    public function dataForCheckCredit()
    {
        return [
            [1, false],
            [2, true],
            [4, true]
        ];
    }

    /**
     * @dataProvider dataForCheckCredit
     * @param $credit
     * @param $expect
     */
    public function testCheckCredit($credit, $expect): void
    {
        $user = new User();
        $user->setCredit($credit);
        self::assertEquals($expect, $user->checkCredit());
    }
}
