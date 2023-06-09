<?php

namespace App\Form;

use App\Entity\Auto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class InsertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', TextType::class)
            ->add('type', TextType::class)
            ->add('kleur', TextType::class)
            ->add('gewicht', NumberType::class)
            ->add('prijs', NumberType::class)
            ->add('voorraad', NumberType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auto::class,
            'require_model' => true,
            'require_type' => true,
            'require_kleur' => true,
            'require_gewicht' => true,
            'require_prijs' => true,
            'require_voorraad' => true,
        ]);
    }
}
