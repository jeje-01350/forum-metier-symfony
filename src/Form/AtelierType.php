<?php

namespace App\Form;

use App\Entity\Atelier;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heureDebut', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2', // Style pour le champ "heureDebut"
                ],
            ])
            ->add('heureFin', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2', // Style pour le champ "heureFin"
                ],
            ])
            ->add('intervenant', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2', // Style pour le champ "salle"
                ],
            ])
            ->add('salle', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2', // Style pour le champ "salle"
                ],
            ])
            ->add('inscription', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2', // Style pour le champ "inscription"
                ],
            ])
            ->add('secteur', null, [
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-4', // Style pour le champ "secteur"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Atelier::class,
        ]);
    }
}
