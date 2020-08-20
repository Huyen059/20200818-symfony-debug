<?php
declare(strict_types=1);
namespace App\Tests;
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);


use App\Entity\Room;
use PHPUnit\Framework\TestCase;

class MaxDurationTest extends TestCase
{
    public function dataForMaxDurationTest()
    {
        return [
            [\DateTime::createFromFormat('H:i', '9:00'), \DateTime::createFromFormat('H:i', '12:00'), true],
            [\DateTime::createFromFormat('H:i', '9:00'), \DateTime::createFromFormat('H:i', '13:00'), true],
            [\DateTime::createFromFormat('H:i', '9:00'), \DateTime::createFromFormat('H:i', '13:01'), false]
        ];
    }

    /**
     * @dataProvider dataForMaxDurationTest
     * @param $start
     * @param $end
     * @param $expect
     */
    public function testMaxDuration($start, $end, $expect): void
    {
        $room = new Room();
        self::assertEquals($expect, $room->checkDuration($start, $end));
    }
}
