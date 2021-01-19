<?php

namespace App\Form;

use App\Entity\Vcard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VcardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('phone')
            ->add('role')
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    "Association" => "Association",
                    "Service administratif"=> "Service administratif",
                    "Entreprise" => "Entreprise",
                ]
            ])
            ->add('text')
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
            'data_class' => Vcard::class,
        ]);
    }
}
