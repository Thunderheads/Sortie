<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner un nom de sortie.")
     * @Assert\Length(min="3", max="100",
     *     minMessage="Trop court. Au moins 3 caractères.",
     *     maxMessage="Trop long. Maximum 100 caractères.")
     * Ceci est un pattern qui interdit l'utilisation de caractères spéciaux dans le champ
     * @Assert\Regex(pattern="/([A-Z]|[a-z])[a-z]*(_)?[a-z]+$/", htmlPattern="/.+/",
     *     message="Le nom de la sortie ne doit pas contenir de caractères spéciaux")
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la date et l'heure du début de la sortie.")
     * @ORM\Column(type="datetime")
     */
    private $dateHeureDebut;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la durée de la sortie en minutes")
     * Cette assert oblige à inscrire un chiffre supérieur à 0
     * @Assert\Positive
     * @ORM\Column(type="smallint")
     */
    private $duree;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la date limite d'inscription à la sortie.")
     * @ORM\Column(type="datetime")
     */
    private $dateLimiteInscription;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner le nombre maximum d'inscrit à la sortie")
     * Cette assert oblige à inscrire un chiffre supérieur à 0
     * @Assert\Positive
     * @ORM\Column(type="smallint")
     */
    private $nbInscriptionMax;

    /**
     * @Assert\Length(min="30", max="5000",
     *     minMessage="Trop court. Au moins 30 caractères.",
     *     maxMessage="Trop long. Maximum 5000 caractères.")
     * @ORM\Column(type="text")
     */
    private $infosSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Lieu;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Campus;

    /**
     * @ORM\ManyToMany(targetEntity=Participant::class, inversedBy="sorties")
     */
    private $Participant;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    public function __construct()
    {
        $this->Participant = new ArrayCollection();
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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionMax(): ?int
    {
        return $this->nbInscriptionMax;
    }

    public function setNbInscriptionMax(int $nbInscriptionMax): self
    {
        $this->nbInscriptionMax = $nbInscriptionMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->Lieu;
    }

    public function setLieu(?Lieu $Lieu): self
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->Campus;
    }

    public function setCampus(?Campus $Campus): self
    {
        $this->Campus = $Campus;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipant(): Collection
    {
        return $this->Participant;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->Participant->contains($participant)) {
            $this->Participant[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        $this->Participant->removeElement($participant);

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }
}
