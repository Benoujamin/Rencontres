<?php

namespace App\Form;

use App\Entity\ProfilPicture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('pic', Filetype::class, [
                'mapped' => false,
                'label' => 'Choissisez un fichier !',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir un fichier !',
                    ]),
                    new Image([
                        'maxSize' => '10M',
                        'maxSizeMessage' => '10 mégas max svp!'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer !'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfilPicture::class,
        ]);
    }
}
