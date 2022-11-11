<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Username', TextType::class, [
                'attr' => [
                    'class'     => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50'
                ],
                'label'      => 'Username',
                'label_attr' => [
                    'class'  => 'form-label mt-4'
                ],
                'constraints' => [
                   
                ]
            ])
            ->add('Adress', TextType::class, [ 'attr' => [ 'class' => 'form-control',] ])
            ->add('Email', TextType::class, [ 'attr' => [ 'class' => 'form-control',] ])
            ->add('submit', SubmitType::class, [ 'attr' => [ 'class' => 'btn btn-primary mt-4 w-50',],
                                                                        'label' => 'Valider'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
