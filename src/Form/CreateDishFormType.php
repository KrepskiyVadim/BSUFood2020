<?php


namespace App\Form;


use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateDishFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('category', EntityType::class,[
                    'class'=>Category::class,
                    'choice_label'=>'name',
                    'multiple'=>false,
                    'expanded'=>false,
                ])
                ->add('price')
                ->add('weight')
                ->add('image');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}