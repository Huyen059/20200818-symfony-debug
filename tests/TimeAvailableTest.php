<?php
declare(strict_types=1);
namespace App\Tests;
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

use App\Entity\Booking;
use App\Entity\Room;
use PHPUnit\Framework\TestCase;

class TimeAvailableTest extends TestCase
{
    public function dataForTimeAvailable()
    {

        // $requestStartDate, $requestEndDate, $bookedStartDate, $bookedEndDate, $expectedResult
        return [
            [
                \DateTime::createFromFormat('H:i', '13:00'),
                \DateTime::createFromFormat('H:i', '17:00'),
                false
            ],
            [
                \DateTime::createFromFormat('H:i', '14:00'),
                \DateTime::createFromFormat('H:i', '15:00'),
                true
            ],
            [
                \DateTime::createFromFormat('H:i', '16:00'),
                \DateTime::createFromFormat('H:i', '18:00'),
                true
            ],
            [
                \DateTime::createFromFormat('H:i', '15:30'),
                \DateTime::createFromFormat('H:i', '18:00'),
                false
            ],
            [
                \DateTime::createFromFormat('H:i', '9:30'),
                \DateTime::createFromFormat('H:i', '11:00'),
                false
            ]
        ];
    }

    /**
     * @dataProvider dataForTimeAvailable
     */
    public function testTimeAvailable($start, $end, $expect)
    {
        $room = new Room();
        $room->setName('Newton')
            ->setIsPremium(false);
        $booked = new Booking();
        $booked->setStartDate(\DateTime::createFromFormat('H:i', '10:00'))
            ->setEndDate(\DateTime::createFromFormat('H:i', '14:00'));
        $booked2 = new Booking();
        $booked2->setStartDate(\DateTime::createFromFormat('H:i', '15:00'))
            ->setEndDate(\DateTime::createFromFormat('H:i', '16:00'));
        $room->addBooking($booked);
        $room->addBooking($booked2);


        self::assertEquals($room->checkTimeAvailability($start, $end), $expect);

    }
}
