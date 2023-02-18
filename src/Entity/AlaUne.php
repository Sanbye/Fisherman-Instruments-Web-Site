<?php

namespace App\Entity;

use App\Repository\AlaUneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlaUneRepository::class)]
class AlaUne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'alaUne', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Section $section = null;

    #[ORM\OneToOne(inversedBy: 'alaUne', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instrument $instrument = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(Instrument $instrument): self
    {
        $this->instrument = $instrument;

        return $this;
    }
}
