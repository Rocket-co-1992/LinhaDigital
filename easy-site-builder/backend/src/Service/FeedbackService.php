<?php

namespace App\Service;

use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;

class FeedbackService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createFeedback(array $data): Feedback
    {
        $feedback = new Feedback();
        $feedback->setName($data['name']);
        $feedback->setEmail($data['email']);
        $feedback->setRating($data['rating']);
        $feedback->setComment($data['comment']);
        $feedback->setDate(new \DateTime());
        $feedback->setIsPublished(false); // Default to not published

        $this->entityManager->persist($feedback);
        $this->entityManager->flush();

        return $feedback;
    }

    public function getFeedbacks(int $siteId): array
    {
        return $this->entityManager->getRepository(Feedback::class)->findBy(['site' => $siteId, 'isPublished' => true]);
    }

    public function moderateFeedback(Feedback $feedback, bool $publish): void
    {
        $feedback->setIsPublished($publish);
        $this->entityManager->flush();
    }

    public function deleteFeedback(Feedback $feedback): void
    {
        $this->entityManager->remove($feedback);
        $this->entityManager->flush();
    }
}