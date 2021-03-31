<?php

namespace App\Form;

use App\Entity\Preference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sexes_recherches')
            ->add('departements_recherches')
            ->add('tranche_age_recherche')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
