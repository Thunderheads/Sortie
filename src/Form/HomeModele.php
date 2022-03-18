<?php

namespace App\Form;



class HomeModele
{

    /**
     * @var : String
     * @private
     */
    private $Campus;

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->Campus;
    }

    /**
     * @param mixed $Campus
     */
    public function setCampus($Campus): void
    {
        $this->Campus = $Campus;
    }

    /**
     * @return mixed
     */
    public function getRecherche()
    {
        return $this->recherche;
    }

    /**
     * @param mixed $recherche
     */
    public function setRecherche($recherche): void
    {
        $this->recherche = $recherche;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateDebutRecherche(): ?\DateTimeInterface
    {
        return $this->dateDebutRecherche;
    }

    /**
     * @param \DateTimeInterface$dateDebutRecherche
     */
    public function setDateDebutRecherche(?\DateTimeInterface $dateDebutRecherche): void
    {
        $this->dateDebutRecherche = $dateDebutRecherche;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTimeInterface $dateFin
     */
    public function setDateFin(?\DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return mixed
     */
    public function getSortieOrganisees()
    {
        return $this->sortieOrganisees;
    }

    /**
     * @param mixed $sortieOrganisees
     */
    public function setSortieOrganisees($sortieOrganisees): void
    {
        $this->sortieOrganisees = $sortieOrganisees;
    }

    /**
     * @return mixed
     */
    public function getSortieInscrit()
    {
        return $this->sortieInscrit;
    }

    /**
     * @param mixed $sortieInscrit
     */
    public function setSortieInscrit($sortieInscrit): void
    {
        $this->sortieInscrit = $sortieInscrit;
    }

    /**
     * @return mixed
     */
    public function getSortieNonInscrit()
    {
        return $this->sortieNonInscrit;
    }

    /**
     * @param mixed $sortieNonInscrit
     */
    public function setSortieNonInscrit($sortieNonInscrit): void
    {
        $this->sortieNonInscrit = $sortieNonInscrit;
    }

    /**
     * @return mixed
     */
    public function getSortiePass()
    {
        return $this->sortiePass;
    }

    /**
     * @param mixed $sortiePass
     */
    public function setSortiePass($sortiePass): void
    {
        $this->sortiePass = $sortiePass;
    }

    /**
     * @var : String
     * @private
     */
    private $recherche;

    /**
     * @var \DateTimeInterface
     * @private
     */
    private $dateDebutRecherche;

    /**
     * @var \DateTimeInterface
     * @private
     */
    private $dateFin;

    /**
     *
     * @private
     */
    private $sortieOrganisees;

    /**
     *
     * @private
     */
    private $sortieInscrit;

    /**
     *
     * @private
     */
    private $sortieNonInscrit;

    /**
     *
     * @private
     */
    private $sortiePass;






}