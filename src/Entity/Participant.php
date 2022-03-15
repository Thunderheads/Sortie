<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre nom.")
     * @Assert\Length(min="3", max="50",
     *     minMessage="Trop court. Au moins 3 caractères.",
     *     maxMessage="Trop long. Maximum 50 caractères.")
     * Ceci est un pattern qui interdit l'utilisation de caractères spéciaux dans le champ
     * @Assert\Regex(pattern="/([A-Z]|[a-z])[a-z]*(_)?[a-z]+$/",htmlPattern="/.+/",
     *     message="Le nom ne doit pas contenir de caractères spéciaux")
     * @ORM\Column(type="string", length=50)
     */
    private $nom;
    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre prenom.")
     * @Assert\Length(min="2", max="50",
     *     minMessage="Trop court. Au moins 2 caractères.",
     *     maxMessage="Trop long. Maximum 50 caractères.")
     * Ceci est un pattern qui interdit l'utilisation de caractères spéciaux dans le champ
     * @Assert\Regex(pattern="/([A-Z]|[a-z])[a-z]*(_)?[a-z]+$/", htmlPattern="/.+/",
     *     message="Le prenom ne doit pas contenir de caractères spéciaux")
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @Assert\Length(min="10", max="10",
     *     minMessage="Le numéro de téléphone doit être composé de 10 numéro",
     *     maxMessage="Le numéro de téléphone doit être composé de 10 numéro")
     * Ceci est un pattern qui oblige l'utilisateur à inscrire que des chiffres(10) avec la possibilités d'utilisé l'indicatifs téléphoniques
     * @Assert\Regex(pattern="/(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/", htmlPattern="/.+/",
     *     message="Saisir un numéro de téléphone")
     * @ORM\Column(type="string", length=50)
     */
    private $telephone;

    /**
     * @Assert\Length(min="10", max="180",
     *     minMessage="Trop court. Au moins 10 caractères.",
     *     maxMessage="Trop long. Maximum 180 caractères.")
     * @Assert\Regex(pattern="/.+\@.+\..+/", htmlPattern="/.+/",
     *     message="Format requis pour l'email : exemple@exemple.com")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\ManyToMany(targetEntity=Sortie::class, mappedBy="Participant")
     */
    private $sorties;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="participant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @Assert\Length(min="5", max="100",
     *     minMessage="Le pseudo doit être composé de 5 caractères au minimum",
     *     maxMessage="Le numéro de téléphone doit être composé de 100 caractères au maximum")
     * @ORM\Column(type="string", length=100)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;


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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->addParticipant($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            $sorty->removeParticipant($this);
        }

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
