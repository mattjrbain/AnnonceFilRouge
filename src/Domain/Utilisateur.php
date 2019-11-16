<?php


namespace Main\Domain;


class Utilisateur extends Entity
{
    /**
     * @var int
     */
    private $user_id;
    /**
     * @var string
     */
    private $nom;
    /**
     * @var string
     */
    private $mot_de_passe;
    /**
     * @var bool
     */
    private $est_admin;

    /**
     * Utilisateur constructor.
     * @param int $user_id
     * @param string $nom
     * @param string $mot_de_passe
     * @param bool $est_admin
     */
    public function __construct(string $nom = "",
                                string $mot_de_passe = "",
                                bool $est_admin = false,
                                int $user_id = -1)
    {
        $this->user_id      = $user_id;
        $this->nom          = $nom;
        $this->mot_de_passe = $mot_de_passe;
        $this->est_admin    = $est_admin;
    }


    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }


    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getMotDePasse(): string
    {
        return $this->mot_de_passe;
    }

    /**
     * @param string $mot_de_passe
     */
    public function setMotDePasse(string $mot_de_passe): void
    {
        $this->mot_de_passe = $mot_de_passe;
    }


    /**
     * @return bool
     */
    public function isEstAdmin(): bool
    {
        return $this->est_admin;
    }

    /**
     * @param bool $est_admin
     */
    public function setEstAdmin(bool $est_admin): void
    {
        $this->est_admin = $est_admin;
    }


}