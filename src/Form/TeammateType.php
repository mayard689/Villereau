<?php

namespace App\Form;

use App\Entity\Teammate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeammateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, ['label' => 'Prénom'])
            ->add('lastname', null, ['label' => 'Nom'])
            ->add('role', ChoiceType::class, [
                'label' => 'Fonction',
                'choices' => [
                    "Maire" => "Maire",
                    "Adjoint"=> "Adjoint",
                    "Conseiller" => "Conseiller",
                    "Agent" => "Agent",
                    "Secrétaire général" => "Secrétaire général"
                ]
            ])
            ->add('type', null, ['label' => 'Type'])
            ->add('text', null, ['label' => 'Présentation'])
            ->add('picture', null, ['label' => 'Photo'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teammate::class,
        ]);
    }
}
