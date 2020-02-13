<?php


namespace Main\Domain;


use DateTime;

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
     * @var string
     */
    private $mail;
    /**
     * @var bool
     */
    private $est_admin;
    /**
     * @var string
     */
    private $confirmation_token;
    /**
     * @var DateTime|null
     */
    private $confirmed_at;
    /**
     * @var DateTime|null
     */
    private $created_at;
    /**
     * @var string
     */
    private $reset_token;
    /**
     * @var DateTime|null
     */
    private $reset_at;

    /**
     * Utilisateur constructor.
     * @param string $nom
     * @param string $mot_de_passe
     * @param string $mail
     * @param string $confirmation_token
     * @param DateTime|null $created_at
     * @param bool $est_admin
     * @param int $user_id
     * @param DateTime|null $confirmed_at
     * @param DateTime|null $reset_at
     * @param string|null $reset_token
     */
    public function __construct(
        string $nom = "",
        string $mot_de_passe = "",
        string $mail = "",
        string $confirmation_token = null,
        DateTime $created_at = null,
        bool $est_admin = false,
        int $user_id = -1,
        DateTime $confirmed_at = null,
        DateTime $reset_at = null,
        string $reset_token = null
    )
    {
        $this->user_id            = $user_id;
        $this->nom                = $nom;
        $this->mot_de_passe       = $mot_de_passe;
        $this->mail               = $mail;
        $this->confirmation_token = $confirmation_token;
        $this->created_at         = $created_at;
        $this->est_admin          = $est_admin;
        $this->confirmed_at       = $confirmed_at;
        $this->reset_at           = $reset_at;
        $this->reset_token        = $reset_token;
    }


    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
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

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    //todo: fix so that never false

    /**
     * @return string
     */
    public function getConfirmationToken(): string
    {
        return $this->confirmation_token;
    }

    /**
     * @param string $confirmation_token
     */
    public function setConfirmationToken(string $confirmation_token): void
    {
        $this->confirmation_token = $confirmation_token;
    }

    public function getConfirmedAt()/*: ?DateTime*/
    {
        return $this->confirmed_at;
    }

    /**
     * @param string $confirmed_at
     */
    public function setConfirmedAt(?string $confirmed_at): void
    {
        $this->confirmed_at = DateTime::createFromFormat('Y-m-d H:i:s', $confirmed_at);
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = DateTime::createFromFormat('Y-m-d H:i:s', $created_at);
    }

    /**
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    /**
     * @param string $reset_token
     */
    public function setResetToken(?string $reset_token): void
    {
        $this->reset_token = $reset_token;
    }

    /**
     * @return DateTime|null
     */
    public function getResetAt(): ?DateTime
    {
        return $this->reset_at;
    }

    /**
     * @param string|null $reset_at
     */
    public function setResetAt(?string $reset_at): void
    {
        $this->reset_at = DateTime::createFromFormat('Y-m-d H:i:s', $reset_at);
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'user' => [
                'id'   => $this->user_id,
                'nom'  => $this->nom,
                'mail' => $this->mail
            ]
        ];
    }
}