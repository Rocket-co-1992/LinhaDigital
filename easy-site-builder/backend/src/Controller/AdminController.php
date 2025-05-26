<?php

namespace App\Controller;

use App\Repository\SiteRepository;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboard(): Response
    {
        $siteRepository = $this->entityManager->getRepository(\App\Entity\Site::class);
        $pageRepository = $this->entityManager->getRepository(\App\Entity\Page::class);
        $feedbackRepository = $this->entityManager->getRepository(\App\Entity\Feedback::class);

        $totalSites = count($siteRepository->findAll());
        $totalPages = count($pageRepository->findAll());
        $totalFeedback = count($feedbackRepository->findAll());

        $recentActivities = [
            'New site created',
            'Page updated',
            'Feedback received',
        ];

        return $this->render('admin/dashboard.html.twig', [
            'totalSites' => $totalSites,
            'totalPages' => $totalPages,
            'totalFeedback' => $totalFeedback,
            'recentActivities' => $recentActivities,
        ]);
    }
}
