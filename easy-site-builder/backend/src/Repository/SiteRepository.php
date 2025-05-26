<?php

namespace App\Repository;

use App\Entity\Site;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function findBySlug(string $slug): ?Site
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllByOwner(int $ownerId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.owner_user_id = :ownerId')
            ->setParameter('ownerId', $ownerId)
            ->orderBy('s.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function save(Site $site): void
    {
        $this->_em->persist($site);
        $this->_em->flush();
    }

    public function remove(Site $site): void
    {
        $this->_em->remove($site);
        $this->_em->flush();
    }
}