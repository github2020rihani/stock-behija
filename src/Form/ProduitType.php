<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('code')
            ->add('designation')
            ->add('unite')
            ->add('quantite')
            ->add('prixHT')
            ->add('tva')
            ->add('Categorie',EntityType::class,[
                'class'=> categories::class])
            ->add('Fournisseur', EntityType::class,[
                'class'=> fournisseur::class,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete',
                'download_label' => 'Download',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
