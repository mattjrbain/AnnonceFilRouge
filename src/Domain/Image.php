<?php


namespace Main\Domain;


class Image extends Entity
{
    /**
     * @var string
     */
    private $imageSrc;
    /**
     * @var int
     */
    private $annonceId;
    /**
     * @var int
     */
    private $imageId;

    /**
     * Image constructor.
     * @param string $imageSrc
     * @param int $annonceId
     * @param int $imageId
     */
    public function __construct(string $imageSrc = "", int $annonceId = -1, int $imageId = -1)
    {
        $this->imageSrc  = $imageSrc;
        $this->annonceId = $annonceId;
        $this->imageId   = $imageId;
    }

    /**
     * @return int
     */
    public function getAnnonceId(): int
    {
        return $this->annonceId;
    }

    /**
     * @param int $annonceId
     */
    public function setAnnonceId(int $annonceId): void
    {
        $this->annonceId = $annonceId;
    }

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     */
    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    public function __toString()
    {
        return $this->getImageSrc();
    }

    /**
     * @return string
     */
    public function getImageSrc(): string
    {
        return $this->imageSrc;
    }

    /**
     * @param string $imageSrc
     */
    public function setImageSrc(string $imageSrc): void
    {
        $this->imageSrc = $imageSrc;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'image' => [
                'id'        => $this->imageId,
                'annonceId' => $this->annonceId,
                'src'       => $this->imageSrc
            ]
        ];
    }
}