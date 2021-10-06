<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteurRepository")
 */
class Compteur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCmd;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $numl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getnumCmd(): ?int
    {
        return $this->numCmd;
    }

    public function setnumCmd(int $numCmd): self
    {
        $this->numCmd = $numCmd;

        return $this;
    }

    public function getNuml(): ?string
    {
        return $this->numl;
    }

    public function setNuml(string $numl): self
    {
        $this->numl = $numl;

        return $this;
    }
}
