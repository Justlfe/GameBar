<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\JeuRepository")
 */
class Jeu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez saisir le nom du jeu")
     * @Assert\Length(
     *     min="2",
     *     minMessage="Le nom du jeux complet doit etre inscrit")
     *
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez saisir un nombre de joueurs min")
     */
    private $joueurs_min;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez saisir un nombre de joueurs max")
     * @Assert\Length(
     *     max="10",
     *     maxMessage="Le nombre de joueur max sur une partie est de 10."
     * )
     */
    private $joueurs_max;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Choisissez une difficulté pour le jeu : facile - moyen - difficile")
     * @Assert\Choice({"facile", "moyen", "difficile"},message="Choisissez une difficulté pour le jeu : facile - moyen - difficile")
     */
    private $difficulty;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     mimeTypesMessage="Inséré ici un fichier contenant une image du jeu",
     *     maxSize="1M", maxSizeMessage="Attention, votre image est trop lourde.")
     * @Assert\NotBlank(message="Vous devez ajouter une image du jeu")
     *
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir un descriptif du jeu")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez indiquer le temps moyen d'une partie")
     */
    private $temps_moyen;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir les regles du jeu")
     */
    private $regles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="jeu")
     */
    private $event;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Bar", inversedBy="jeux")
     */
    private $bar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->event = new ArrayCollection();
        $this->bar = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getImage()

    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTempsMoyen(): ?string
    {
        return $this->temps_moyen;
    }

    public function setTempsMoyen(string $temps_moyen): self
    {
        $this->temps_moyen = $temps_moyen;

        return $this;
    }

    public function getRegles()
    {
        return $this->regles;
    }

    public function setRegles($regles): self
    {
        $this->regles = $regles;

        return $this;
    }

    /**
     * @return Collection|event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setJeu($this);
        }

        return $this;
    }

    public function removeEvent(event $event): self
    {
        if ($this->event->contains($event)) {
            $this->event->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getJeu() === $this) {
                $event->setJeu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|bar[]
     */
    public function getBar(): Collection
    {
        return $this->bar;
    }

    public function addBar(bar $bar): self
    {
        if (!$this->bar->contains($bar)) {
            $this->bar[] = $bar;
        }

        return $this;
    }

    public function removeBar(bar $bar): self
    {
        if ($this->bar->contains($bar)) {
            $this->bar->removeElement($bar);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
