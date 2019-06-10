<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 * @UniqueEntity(fields={"email"}, errorPath="email", message="Ce compte existe déjà !")
 */
class Membre implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir un pseudo avec un minimum de 4 caractères")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Votre pseudo ne doit pas dépasser {{ limit }} caractères.",
     *     min="4",
     *     minMessage="Votre pseudo ne doit comprendre au moins {{ limit }} caractères."
     * )
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir un email")
     * @Assert\Email(message="le champs ne correspond pas au format email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe")
     *
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir votre nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir votre prenom")
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez saisir votre code postal")
     * @Assert\Length(
     *     min="5",
     *     minMessage="le code postal comporte 5 chiffres",
     *     max="5",
     *     maxMessage="le code postal comporte 5 chiffres"
     * )
     */
    private $code_postal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Bar", mappedBy="gerant")
     */
    private $bar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="joueurs")
     */
    private $event;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    public function __construct()
    {
        $this->event = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getBar(): ?bar
    {
        return $this->bar;
    }

    public function setBar(?bar $bar): self
    {
        $this->bar = $bar;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
        }

        return $this;
    }

    public function removeEvent(event $event): self
    {
        if ($this->event->contains($event)) {
            $this->event->removeElement($event);
        }

        return $this;
    }

    /**
     * @return string|null
     *
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string The username
     */
    public function getUsername()
    {
        return $this->pseudo;
    }

    /**
     *
     */
    public function eraseCredentials()
    {

    }

}
