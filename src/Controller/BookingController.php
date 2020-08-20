<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Room;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $booking = new Booking();
        $user = $this->getUser();
        $booking->setUser($user);
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($booking->getStartDate() < new \DateTime() || $booking->getEndDate() < $booking->getStartDate()) {
                $errorMessage = "Please check your booking details. Start date can't be set in the past and end date can't be earlier than start date.";
                return $this->render('booking/new.html.twig', [
                    'booking' => $booking,
                    'form' => $form->createView(),
                    'errorMessage' => $errorMessage
                ]);
            }

            if(!$booking->getRoom()->checkAvailability($booking->getUser())) {
                $errorMessage = "You don't have permission to book this room.";
                return $this->render('booking/new.html.twig', [
                    'booking' => $booking,
                    'form' => $form->createView(),
                    'errorMessage' => $errorMessage
                ]);
            }

            if(!$booking->getRoom()->checkTimeAvailability($booking->getStartDate(), $booking->getEndDate())) {
                $errorMessage = "The room is not available for the specified period.";
                return $this->render('booking/new.html.twig', [
                    'booking' => $booking,
                    'form' => $form->createView(),
                    'errorMessage' => $errorMessage
                ]);
            }

            if(!$booking->getRoom()->checkDuration($booking->getStartDate(), $booking->getEndDate())) {
                $errorMessage = "Booking period can't be longer than 4 hours.";
                return $this->render('booking/new.html.twig', [
                    'booking' => $booking,
                    'form' => $form->createView(),
                    'errorMessage' => $errorMessage
                ]);
            }

            if(!$booking->getUser()->checkCredit()) {
                $errorMessage = "You don't have enough credit.";
                return $this->render('booking/new.html.twig', [
                    'booking' => $booking,
                    'form' => $form->createView(),
                    'errorMessage' => $errorMessage
                ]);
            }

            $booking->getUser()->setCredit($booking->getUser()->getCredit() - Room::RENT);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index');
    }
}
