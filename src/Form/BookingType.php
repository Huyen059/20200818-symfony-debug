<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $start = \DateTime::createFromFormat('H:i', '09:00');
        $end = \DateTime::createFromFormat('H:i', '18:00');
        $now = new \DateTime();

        if($now < $start) {
            $startDate = $start;
            $endDate = $end;
        } elseif ($now >= $start && $now <= $end) {
            $startDate = $now;
            $endDate = $end;
        } elseif ($now > $end) {
            $startDate = $start->add(new \DateInterval('P1D'));
            $endDate = $end->add(new \DateInterval('P1D'));
        }

        $builder
            ->add('startDate', DateTimeType::class, [
                'data' => $startDate
            ])
            ->add('endDate', DateTimeType::class, [
                'data' => $endDate
            ])
            ->add('room')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
