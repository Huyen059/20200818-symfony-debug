<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPremium;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="room")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsPremium(): ?bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(bool $isPremium): self
    {
        $this->isPremium = $isPremium;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getRoom() === $this) {
                $booking->setRoom(null);
            }
        }

        return $this;
    }

    public function checkAvailability(User $user): bool
    {
        return $user->getIsPremium() || !$this->getIsPremium();
    }

    public function checkTimeAvailability(\DateTimeInterface $startDate,\DateTimeInterface $endDate): bool
    {
        foreach ($this->bookings as $booking) {
            /** @var Booking $booking */
            $bookedStartDate = $booking->getStartDate();
            $bookedEndDate = $booking->getEndDate();
            if($startDate < $bookedStartDate && $endDate > $bookedStartDate) {
                return false;
            }

            if($startDate > $bookedStartDate && $startDate < $bookedEndDate) {
                return false;
            }
        }
        return true;
    }

    public function checkDuration(\DateTimeInterface $start,\DateTimeInterface $end): bool
    {
        return $start->add(new \DateInterval('PT4H')) >= $end;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
