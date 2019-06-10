<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BarRepository")
 */
class Bar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir le nom de votre bar")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le nom du bar ne doit pas dépasser {{ limit }} caractères",     *
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir l'adresse de votre bar")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Votre adresse ne peux pas dépasser {{ limit }} caracteres"
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir la ville ou se trouve vvotre bar")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Le nom de ville ne peux pas dépasser {{ limit }} caracteres"
     * )
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez saisir le code postal du bar")
     *
     */
    private $code_postal;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer le nombre de places disponible dans le bar")
     *
     */
    private $places_max;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $autres_infos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Membre", inversedBy="bar")
     */
    private $gerant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Jeu", mappedBy="bar")
     */
    private $jeux;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="bar")
     */
    private $events;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     mimeTypesMessage="Vous devez saisir un fichier contenant une image du bar",
     *     maxSize="1M", maxSizeMessage="Attention, votre image est trop lourde.")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(
     *     mimeTypesMessage="Vous devez saisir un fichier contenant une image de votre kbis",
     *     maxSize="1M", maxSizeMessage="Attention, votre fichier est trop lourde.")
     */
    private $kbis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lng;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
        $this->events = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getPlacesMax(): ?int
    {
        return $this->places_max;
    }

    public function setPlacesMax(int $places_max): self
    {
        $this->places_max = $places_max;

        return $this;
    }

    public function getAutresInfos(): ?string
    {
        return $this->autres_infos;
    }

    public function setAutresInfos(?string $autres_infos): self
    {
        $this->autres_infos = $autres_infos;

        return $this;
    }

    public function getGerant(): ?Membre
    {
        return $this->gerant;
    }

    public function setGerant(Membre $gerant): self
    {
        $this->gerant = $gerant;

        // set the owning side of the relation if necessary
        if ($this !== $gerant->getBar()) {
            $gerant->setBar($this);
        }

        return $this;
    }

    /**
     * @return Collection|Jeu[]
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(Jeu $jeux): self
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux[] = $jeux;
            $jeux->addBar($this);
        }

        return $this;
    }

    public function removeJeux(Jeu $jeux): self
    {
        if ($this->jeux->contains($jeux)) {
            $this->jeux->removeElement($jeux);
            $jeux->removeBar($this);
        }

        return $this;
    }

    /**
     * @return Collection|event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setBar($this);
        }

        return $this;
    }

    public function removeEvent(event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getBar() === $this) {
                $event->setBar(null);
            }
        }

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

    public function getKbis()
    {
        return $this->kbis;
    }

    public function setKbis($kbis): self
    {
        $this->kbis = $kbis;

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

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }


}
