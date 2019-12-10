<?php


namespace Main\Domain;


use DateInterval;
use DateTime;
use Exception;
use Main\DAO\DAO;
use Main\DAO\DAOException;
use Main\DAO\MySQLAnnonceDAO;

class Annonce extends Entity
{
    CONST VALIDITE_MAX = 28;

    /**
     * @var Utilisateur
     */
    private $user;
    /**
     * @var Rubrique
     */
    private $rubrique;
    /**
     * @var int
     */
    private $annonce_id;
//    /**
//     * @var int
//     */
//    private $user_id;
//    /**
//     * @var int
//     */
//    private $rubrique_id;
    /**
     * @var string
     */
    private $en_tete;
    /**
     * @var string
     */
    private $corps;
    /**
     * @var DateTime
     */
    private $date_limite;
    /**
     * @var DateTime
     */
    private $date_creation;
    /**
     * @var DateTime
     */
    private $date_modif;
    /**
     * @var int
     */
    private $nb_visites;
//    /**
//     * @var MySQLAnnonceDAO
//     */
//    private $dao;
    /**
     * @var array
     */
    private $imgs;

    /**
     * Annonce constructor.
     * @param Utilisateur $user
     * @param Rubrique|null $rubrique
     * @param string $en_tete
     * @param string $corps
     * @param array $imgs
     * @param int|null $nb_visites
     * @param DateTime $date_creation
     * @param int $annonce_id
     */
    public function __construct(
        Utilisateur $user = null,
        Rubrique $rubrique = null,
        string $en_tete = "",
        string $corps = "",
        array $imgs = array(),
        int $nb_visites = null,
        DateTime $date_creation = null,
        int $annonce_id = -1)
    {
        $this->user          = $user;
        $this->rubrique      = $rubrique;
        $this->en_tete       = $en_tete;
        $this->corps         = $corps;
        $this->date_creation = $date_creation;
        $this->annonce_id    = $annonce_id;
        $this->imgs          = $imgs;
        $this->nb_visites    = $nb_visites;
        //$this->dao           = new MySQLAnnonceDAO();
    }


    /**
     * @return int
     */
    public function getAnnonceId(): int
    {
        return $this->annonce_id;
    }

    /**
     * @param int $annonce_id
     */
    public function setAnnonceId(int $annonce_id): void
    {
        $this->annonce_id = $annonce_id;
    }

    /**
     * !!!Sets user from user id , does not set user id !!!
     *
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->user = DAO::get('Utilisateur')->getById($userId);
    }

    /**
     * !!! Sets "rubrique" from its id !!!
     *
     * @param int $rubriqueId
     */
    public function setRubriqueId(int $rubriqueId): void
    {
        $this->rubrique = DAO::get('Rubrique')->getById($rubriqueId);
    }

    /**
     * @return string
     */
    public function getEnTete(): string
    {
        return $this->en_tete;
    }

    /**
     * @param string $en_tete
     */
    public function setEnTete(string $en_tete): void
    {
        $this->en_tete = $en_tete;
    }

    /**
     * @return string
     */
    public function getCorps(): string
    {
        return $this->corps;
    }

    /**
     * @param string $corps
     */
    public function setCorps(string $corps): void
    {
        $this->corps = $corps;
    }

    /**
     * @return DateTime
     */
    public function getDateLimite(): DateTime
    {
        return $this->date_limite;
    }

    /**
     * @param string $date_limite
     */
    public function setDateLimite(string $date_limite): void
    {
        $this->date_limite = DateTime::createFromFormat('Y-m-d H:i:s', $date_limite);
    }

    /**
     * @return DateTime
     */
    public function getDateCreation(): DateTime
    {
        return $this->date_creation;
    }

    /**
     * @param string $date_creation
     * @throws Exception
     */
    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = DateTime::createFromFormat('Y-m-d H:i:s', $date_creation);
    }

    /**
     * @return int
     */
    public function getNbVisites(): int
    {
        return $this->nb_visites;
    }

    /**
     * @param int $nb_visites
     */
    public function setNbVisites(int $nb_visites): void
    {
        $this->nb_visites = $nb_visites;
    }

    /**
     * @return Utilisateur
     */
    public function getUser(): Utilisateur
    {
        return $this->user;
    }

    /**
     * @param Utilisateur $user
     */
    public function setUser(Utilisateur $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Rubrique
     */
    public function getRubrique(): Rubrique
    {
        return $this->rubrique;
    }

    /**
     * @param Rubrique $rubrique
     */
    public function setRubrique(Rubrique $rubrique): void
    {
        $this->rubrique = $rubrique;
    }

    /**
     * @return DateTime
     */
    public function getDateModif(): DateTime
    {
        return $this->date_modif;
    }

    /**
     * @param string $date_modif
     */
    public function setDateModif(string $date_modif): void
    {
        $this->date_modif = DateTime::createFromFormat('Y-m-d H:i:s', $date_modif);
    }

    /**
     * @return mixed
     */
    public function getImgs()
    {
        return $this->imgs;
    }

    /**
     * @param array $imgs
     */
    public function setImages(array $imgs): void
    {
        $this->imgs = $imgs;
    }


}