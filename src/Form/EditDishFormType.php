<?php


namespace App\Form;


use App\Entity\Category;
use App\Entity\Dish;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditDishFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('category', EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
                'attr' =>[
                    'value'=>$options['category']
                ]
            ])
            ->add('price', null, ['attr' =>[
        'value'=>$options['price']]
    ])
            ->add('weight')
            ->add('image');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
            'name' => null,
            'category' => null,
            'weight' => null,
            'price' => null,
        ]);
    }
}