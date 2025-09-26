<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [new Assert\NotBlank(), new Assert\Email()],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 8, minMessage: 'Le mot de passe doit contenir au moins 8 caractères'),
                ],
            ])
            ->add('companyName', TextType::class, [
                'mapped' => false,
                'label' => 'Nom de l’entreprise',
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('companySiret', TextType::class, [
                'mapped' => false,
                'label' => 'SIRET',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}