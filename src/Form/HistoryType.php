<?php

namespace App\Form;

use App\Entity\AutomobileHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('n_immatriculation')
            ->add('etat')
            ->add('kilometrage')
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AutomobileHistory::class,
        ]);
    }
}
