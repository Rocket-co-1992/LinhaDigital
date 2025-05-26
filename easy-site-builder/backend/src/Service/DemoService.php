<?php

namespace App\Service;

use App\Entity\DemoInstance;
use Doctrine\ORM\EntityManagerInterface;

class DemoService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createDemoInstance(array $data): DemoInstance
    {
        $demoInstance = new DemoInstance();
        $demoInstance->setSiteId($data['site_id']);
        $demoInstance->setSlug($data['slug']);
        $demoInstance->setSubdomain($data['subdomain']);
        $demoInstance->setIncludeDrafts($data['include_drafts']);
        $demoInstance->setCreatedAt(new \DateTime());
        $demoInstance->setExpiresAt(new \DateTime("+{$data['demo_duration']} days"));
        $demoInstance->setIsActive(true);

        $this->entityManager->persist($demoInstance);
        $this->entityManager->flush();

        return $demoInstance;
    }

    public function expireDemoInstances(): void
    {
        $now = new \DateTime();
        $expiredDemos = $this->entityManager->getRepository(DemoInstance::class)->findBy(['expiresAt' => ['<=' => $now], 'isActive' => true]);

        foreach ($expiredDemos as $demo) {
            $demo->setIsActive(false);
            $this->entityManager->persist($demo);
        }

        $this->entityManager->flush();
    }

    public function renewDemoInstance(DemoInstance $demoInstance, int $additionalDays): void
    {
        $newExpiryDate = (clone $demoInstance->getExpiresAt())->modify("+{$additionalDays} days");
        $demoInstance->setExpiresAt($newExpiryDate);
        $this->entityManager->persist($demoInstance);
        $this->entityManager->flush();
    }
}