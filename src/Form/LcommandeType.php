<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Lcommande;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\IntegerType;;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LcommandeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', EntityType::class, array(
                'class' => Produit::class,
                'choice_label' => 'designation' ))
            ->add('prixHt', )
            ->add('qte')
        ->add('tva');






    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lcommande::class,
        ]);
    }
}
