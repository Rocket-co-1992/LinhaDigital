<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findBySiteId($siteId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.site = :siteId')
            ->setParameter('siteId', $siteId)
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPublishedPages($siteId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.site = :siteId')
            ->andWhere('p.isPublished = :published')
            ->setParameter('siteId', $siteId)
            ->setParameter('published', true)
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneBySlug($slug, $siteId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.slug = :slug')
            ->andWhere('p.site = :siteId')
            ->setParameter('slug', $slug)
            ->setParameter('siteId', $siteId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}