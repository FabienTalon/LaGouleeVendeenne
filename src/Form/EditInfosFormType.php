<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditInfosFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('horairesmatinsemaine',textType::class,[
                'label' => 'Changer les horaires du Lundi - Vendredi (Matin)',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('horairessoirsemaine', textType::class, [
                'label' => 'Changer les horaires du Lundi - Vendredi (Soir)',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('horairesmatinwk', textType::class, [
                'label' => 'Changer les horaires du Samedi (Matin)',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('horairessoirwk', textType::class, [
                'label' => 'Changer les horaires du Samedi (Soir)',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('valideredition', SubmitType::class, [
                'label' => 'Valider',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
