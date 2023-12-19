<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Salle;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                    'class' => 'border rounded py-2 px-3 w-full mb-2',
                ],
            ])
            ->add('heureFin', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2',
                ],
            ])
            ->add('intervenant', null, [
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2',
                ],
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => true,
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-2',
                ],
            ])
            ->add('secteur', null, [
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => true,
                'attr' => [
                    'class' => 'border rounded py-2 px-3 w-full mb-4',
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
