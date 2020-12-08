<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\NewspaperSubject2;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewspaperSubject2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', EntityType::class, [
                'class' => Content::class,
                'choice_label' => 'title',
                'multiple'=>false,
                'expanded'=>false,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewspaperSubject2::class,
        ]);
    }
}
