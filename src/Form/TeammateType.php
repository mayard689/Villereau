<?php

namespace App\Form;

use App\Entity\Teammate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TeammateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, ['label' => 'Prénom'])
            ->add('lastname', null, ['label' => 'Nom'])
            ->add('role', null, ['label' => 'Rôle'])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    "Maire" => "Maire",
                    "Adjoint"=> "Adjoint",
                    "Conseiller" => "Conseiller",
                    "Agent" => "Agent",
                    "Secrétaire général" => "Secrétaire général"
                ]
            ])
            ->add('text', null, ['label' => 'Présentation'])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_label' => '...',
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Photo',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teammate::class,
        ]);
    }
}
