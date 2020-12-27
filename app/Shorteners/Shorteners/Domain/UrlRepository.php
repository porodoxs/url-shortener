<?php

namespace App\Shorteners\Shorteners\Domain;

use Doctrine\ORM\EntityManager;

class UrlRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Url
    {
        $entity = Url::class;

        $query = "SELECT url FROM {$entity} url
                  WHERE url.id = :id";

        return $this->entityManager
            ->createQuery($query)
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function findCurrentByOriginalUrl(string $originalUrl): ?Url
    {
        $entity = Url::class;

        $query = "SELECT url FROM {$entity} url
                  WHERE url.originalUrl = :originalUrl";

        return $this->entityManager
            ->createQuery($query)
            ->setParameter('originalUrl', $originalUrl)
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

    public function save(Url $url): void
    {
        $em = $this->entityManager;

        $em->persist($url);
        $em->flush();
    }
}
