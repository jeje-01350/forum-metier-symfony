<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('forum', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'nom', // Remplacez 'nom' par la propriété à afficher dans la liste déroulante
                'placeholder' => 'Sélectionnez un forum', // Optionnel : texte par défaut
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteur::class,
        ]);
    }
}
