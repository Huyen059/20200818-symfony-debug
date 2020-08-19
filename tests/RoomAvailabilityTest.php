<?php
declare(strict_types=1);
namespace App\Tests;
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

use App\Entity\Room;
use App\Entity\User;
use PHPUnit\Framework\TestCase;


//Rooms marked as premium can only be hired for premium members
class RoomAvailabilityTest extends TestCase
{
    public function dataForRoomAvailabilityTest(): array
    {
        return [
            [true, true, true],
            [false, false, true],
            [false, true, true],
            [true, false, false]
        ];
    }

    /**
     * @dataProvider dataForRoomAvailabilityTest
     * @param bool $roomVar
     * @param bool $userVar
     * @param bool $expectedOutput
     */
    public function testSum(bool $roomVar, bool $userVar, bool $expectedOutput): void
    {
        $user = new User();
        $user->setIsPremium($userVar);
        $room = new Room();
        $room->setIsPremium($roomVar);
        $room->checkAvailability($user);

        self::assertEquals($expectedOutput, $room->checkAvailability($user));
    }
}
