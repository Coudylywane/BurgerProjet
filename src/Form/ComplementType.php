<?php

namespace App\Form;

use App\Entity\Complement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ComplementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('description', TextareaType::class,[

                ])
            ->add('image',FileType::class,[
                'attr'=>[
                    'class'=> 'mt-4'
                ],
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Complement::class,
        ]);
    }
}
