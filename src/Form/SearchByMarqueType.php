<?php

namespace App\Form;

use App\Entity\SearchByMarque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchByMarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Marque',EntityType::class, array(
                'required' => true,                
                'placeholder' => 'Select the Marque',
                'class' => 'App:Marque'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchByMarque::class,
        ]);
    }
}
