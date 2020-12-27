<?php

namespace App\Shorteners\Shorteners\Domain;

use Doctrine\ORM\Mapping AS ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity
 * @ORM\Table(name="urls")
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $originalUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct(
        string $originalUrl
    ) {
        $this->originalUrl = $originalUrl;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function updateOriginalUrl(string $newOriginalUrl)
    {
        $this->originalUrl = $newOriginalUrl;

        $this->changeUpdateAt();
    }

    private function changeUpdateAt()
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
