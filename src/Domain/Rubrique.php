<?php


namespace Main\Domain;


class Rubrique extends Entity
{
    /**
     * @var int
     */
    private $rubrique_id;
    /**
     * @var string
     */
    private $libelle;

    /**
     * Rubrique constructor.
     * @param int $rubrique_id
     * @param string $libelle
     */
    public function __construct(string $libelle = "",int $rubrique_id = -1)
    {
        $this->rubrique_id = $rubrique_id;
        $this->libelle     = $libelle;
    }


    /**
     * @return int
     */
    public function getRubriqueId(): int
    {
        return $this->rubrique_id;
    }

    /**
     * @param int $rubrique_id
     */
    public function setRubriqueId(int $rubrique_id): void
    {
        $this->rubrique_id = $rubrique_id;
    }

    /**
     * @return string
     */
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }



}