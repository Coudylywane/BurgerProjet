<?php

namespace App\Form;

use App\Entity\Burger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;

class BurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class,[
                "required"=> false ,
                "constraints" => [
                    new NotBlank([
                        "message"=> "Champ Obligatoire."
                    ])

                ]
            ])
            ->add('nom', TextType::class,[
                "required"=> false ,
                "constraints" => [
                    new NotBlank([
                        "message"=> "Champ Obligatoire."
                    ])
                ]
            ])
            ->add('prix', TextType::class,[
                "required"=> false ,
                "constraints" => [
                    new NotBlank([
                        "message"=> "Champ Obligatoire."
                    ])

                ]
            ])

            ->add('image',FileType::class,[
                'attr'=>[
                    'class'=> 'mt-4'
                ],
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false,
                "constraints" => [
                    new NotBlank([
                        "message"=> "Champ Obligatoire."
                    ])
                    
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Burger::class,
        ]);
    }
}
