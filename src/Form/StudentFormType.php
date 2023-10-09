<?php

namespace App\Form;

use App\Entity\Specialitate;
use App\Entity\Student;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class StudentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nume',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Numele trebuie sa aiba minim 3 caractere',
                        'max' => 50,
                        'maxMessage' => 'Numele trebuie sa aiba maxim 255 caractere',
                    ]),
                    new NotBlank([
                        'message' => 'Numele nu poate fi gol',
                    ]),
                    new Regex(
                        pattern: '/^[a-zA-ZîâățșȘȚĂÎÂ]+$/',
                        message:  'Numele trebuie sa contina doar litere',
                    ),
                ]
            ])
            ->add('media', NumberType::class,[
                'label' => 'Media',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Media trebuie sa aiba minim 1 cifra',
                        'max' => 10,
                        'maxMessage' => 'Media trebuie sa aiba maxim 10 cifre',
                    ]),
                    new NotBlank([
                        'message' => 'Media nu poate fi goala',
                    ]),
                    new Regex(
                        pattern: '/^(10(\.00?)?|[1-9](\.[0-9]{1,2})?)$/',
                        message:  'Media trebuie sa fie intre 1.00 si 10.00',
                    ),
                ],
            ])
            ->add('birthdate', DateType::class,[
                'label' => 'Data nasterii',
                'attr' => [
                    'class' => 'form-control date',
                    'data-provide' => 'datepicker',
                ],
            ])
            ->add('grupa', TextType::class,[
                'label' => 'Grupa',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Grupa trebuie sa aiba minim 2 caractere',
                        'max' => 10,
                        'maxMessage' => 'Grupa trebuie sa aiba maxim 10 caractere',
                    ]),
                    new NotBlank([
                        'message' => 'Grupa nu poate fi goala',
                    ]),

                    new Regex(
                        pattern: '/^[a-zA-Z]{2}[0-9]{4}$/',
                        message:  'Grupa trebuie sa fie de forma LLNNNN',

                    )
                ],
            ])
            ->add('specialitate', EntityType::class,[
                'label' => 'Specialitatea',
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Specialitate::class,
                'choice_label' => 'nume',
//                 'constraints' => [
//                     new Type('App\Entity\Specialitate', 'Specialitatea nu exista'),
//
//                 ],

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
