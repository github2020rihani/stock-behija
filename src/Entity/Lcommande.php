<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LcommandeRepository")
 */
class Lcommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=50)
     */
    private $qte;

    /**
     * @ORM\Column(type="decimal", length=50)
     */
    private $prixHt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $tva;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="lcommandes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?string
    {
        return $this->qte;
    }

    public function setQte(string $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixHt(): ?string
    {
        return $this->prixHt;
    }

    public function setPrixHt(string $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

}
