<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numCmd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCmd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $satusCmd;


    /**
     * @var \DateTime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Lcommande::class, mappedBy="commande", cascade={"all"})
     */
    private $lcommandes;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    public function __construct()
    {
        $this->lcommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCmd(): ?string
    {
        return $this->numCmd;
    }

    public function setNumCmd(string $numCmd): self
    {
        $this->numCmd = $numCmd;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->dateCmd;
    }

    public function setDateCmd(\DateTimeInterface $dateCmd): self
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function getSatusCmd(): ?string
    {
        return $this->satusCmd;
    }

    public function setSatusCmd(string $satusCmd): self
    {
        $this->satusCmd = $satusCmd;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Lcommande[]
     */
    public function getLcommandes(): Collection
    {
        return $this->lcommandes;
    }

    public function addLcommande(Lcommande $lcommande): self
    {
        if (!$this->lcommandes->contains($lcommande)) {
            $this->lcommandes[] = $lcommande;
            $lcommande->setCommande($this);
        }

        return $this;
    }

    public function removeLcommande(Lcommande $lcommande): self
    {
        if ($this->lcommandes->removeElement($lcommande)) {
            // set the owning side to null (unless already changed)
            if ($lcommande->getCommande() === $this) {
                $lcommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }


}
