<?php


namespace App\Form;


use App\Entity\Dish;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateDishCompositionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dish', EntityType::class,[
                'class'=>Dish::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('ingredient', EntityType::class,[
                'class'=>Ingredient::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}