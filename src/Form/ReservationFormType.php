<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
                'attr' => [
                    'min' => date('Y-m-d'), // Définit la date minimale
                    'class' => 'form-control'
                ],
            ])

            ->add('email', EmailType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])

            ->add('heure', ChoiceType::class, [
                'choices' => $this->generateHeureMinuteChoices(),
                'placeholder' => 'Heure',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])

            ->add('nombre_couverts', IntegerType::class, [
                'label' => 'Nombre de couverts',
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'class' => 'form-control',
                ],
                'required' => true,
            ])

            ->add('allergies', TextareaType::class, [
                'label' => 'Avez-vous des allergies ? Si oui, lesquelles ?',
                'required' => false,
                'attr' => [
                    'rows' => 3,
                    'class' => 'form-control',
                ]
            ])

            ->add('reserver', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                    'id' => 'reservationBtn', // Ajoutez cet ID
                ],
            ]);

    }

    private function generateHeureMinuteChoices(): array
    {
        $currentTime = new \DateTime();
        $currentHour = (int) $currentTime->format('H');
        $currentMinutes = (int) $currentTime->format('i');
        $currentDay = (int) $currentTime->format('d');

        $choices = [];

        // Vérifier si aujourd'hui est un samedi
        if ($currentTime->format('N') === '6') {
            if ($currentDay === (int) $currentTime->format('d')) {
                if ($currentMinutes < 30) {
                    $choices[$currentHour . ':30'] = $currentHour . ':30';
                }
                for ($hour = $currentHour + 1; $hour <= 22; $hour++) {
                    $choices[$hour . ':00'] = $hour . ':00';
                    $choices[$hour . ':30'] = $hour . ':30';
                }
            } else {
                for ($hour = 12; $hour <= 22; $hour++) {
                    $choices[$hour . ':00'] = $hour . ':00';
                    if ($hour != 22) {
                        $choices[$hour . ':30'] = $hour . ':30';
                    }
                }
            }
        } else {
            if ($currentDay === (int) $currentTime->format('d')) {
                if ($currentMinutes < 30 && $currentHour != 14 && $currentHour != 22) {
                    $choices[$currentHour . ':30'] = $currentHour . ':30';
                }
                for ($hour = $currentHour + 1; $hour <= 14; $hour++) {
                    $choices[$hour . ':00'] = $hour . ':00';
                    $choices[$hour . ':30'] = $hour . ':30';
                }
                for ($hour = 19; $hour <= 22; $hour++) {
                    $choices[$hour . ':00'] = $hour . ':00';
                    if ($hour != 22) {
                        $choices[$hour . ':30'] = $hour . ':30';
                    }
                }
            } else {
                for ($hour = 12; $hour <= 14; $hour++) {
                    $choices[$hour . ':00'] = $hour . ':00';
                    if ($hour != 14) {
                        $choices[$hour . ':30'] = $hour . ':30';
                    }
                }
                for ($hour = 19; $hour <= 22; $hour++) {
                    $choices[$hour . ':00'] = $hour . ':00';
                    if ($hour != 22) {
                        $choices[$hour . ':30'] = $hour . ':30';
                    }
                }
            }
        }

        return $choices;
    }





    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configurez ici les options par défaut pour le formulaire
        ]);
    }
}