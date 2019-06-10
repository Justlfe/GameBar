<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $joueurs_min;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *     max="10",
     *     maxMessage="Une partie doit contenir au maximum {{ limit }} joueurs")
     */
    private $joueurs_max;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heure_debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heure_fin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $autre_infos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Membre", mappedBy="event")
     */
    private $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jeu", inversedBy="event")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jeu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bar", inversedBy="events")
     */
    private $bar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmation;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoueursMin(): ?int
    {
        return $this->joueurs_min;
    }

    public function setJoueursMin(int $joueurs_min): self
    {
        $this->joueurs_min = $joueurs_min;

        return $this;
    }

    public function getJoueursMax(): ?int
    {
        return $this->joueurs_max;
    }

    public function setJoueursMax(int $joueurs_max): self
    {
        $this->joueurs_max = $joueurs_max;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getAutreInfos(): ?string
    {
        return $this->autre_infos;
    }

    public function setAutreInfos(?string $autre_infos): self
    {
        $this->autre_infos = $autre_infos;

        return $this;
    }

    /**
     * @return Collection|Membre[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Membre $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
            $joueur->addEvent($this);
        }

        return $this;
    }

    public function removeJoueur(Membre $joueur): self
    {
        if ($this->joueurs->contains($joueur)) {
            $this->joueurs->removeElement($joueur);
            $joueur->removeEvent($this);
        }

        return $this;
    }

    public function getJeu(): ?Jeu
    {
        return $this->jeu;
    }

    public function setJeu(?Jeu $jeu): self
    {
        $this->jeu = $jeu;

        return $this;
    }

    public function getBar(): ?Bar
    {
        return $this->bar;
    }

    public function setBar(?Bar $bar): self
    {
        $this->bar = $bar;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;


        return $this;
    }

    public function getConfirmation(): ?bool
    {
        return $this->confirmation;
    }

    public function setConfirmation(bool $confirmation): self
    {
        $this->confirmation = $confirmation;

        return $this;
    }
}
