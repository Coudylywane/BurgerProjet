<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_menu')
            ->add('prix_menu')
            ->add('description')
            ->add('burgers')
            ->add('complements')
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
            'data_class' => Menu::class,
        ]);
    }
}
