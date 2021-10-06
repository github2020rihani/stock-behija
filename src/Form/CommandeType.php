<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('numCmd',TextType::class,[
//            ])
            ->add('dateCmd',DateTimeType::class,[
                'widget' => 'single_text'
            ])
            ->add('satusCmd', TextType::class, array(
                'label' => 'Observation : '))
            ->add('client', EntityType::class,[
                'class'=> Client::class,
                'choice_label'=>'nom'
                ])
            ->add('fournisseur',  EntityType::class,[
                'class' => Fournisseur::class
            ])
            ->add('lcommandes', CollectionType::class, array(
                'entry_type' => LcommandeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,


        ]);
    }
}
