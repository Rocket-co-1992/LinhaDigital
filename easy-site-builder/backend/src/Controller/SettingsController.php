<?php

namespace App\Controller;

use App\Entity\SiteSettings;
use App\Form\SettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/settings", name="settings_index")
     */
    public function index(Request $request): Response
    {
        $siteSettings = $this->entityManager->getRepository(SiteSettings::class)->find(1);

        $form = $this->createForm(SettingsType::class, $siteSettings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Settings updated successfully.');

            return $this->redirectToRoute('settings_index');
        }

        return $this->render('admin/settings/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}