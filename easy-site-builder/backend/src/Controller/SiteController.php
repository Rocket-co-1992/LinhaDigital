<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    private $entityManager;
    private $siteRepository;

    public function __construct(EntityManagerInterface $entityManager, SiteRepository $siteRepository)
    {
        $this->entityManager = $entityManager;
        $this->siteRepository = $siteRepository;
    }

    /**
     * @Route("/admin/sites", name="site_index")
     */
    public function index(): Response
    {
        $sites = $this->siteRepository->findAll();

        return $this->render('admin/sites/index.html.twig', [
            'sites' => $sites,
        ]);
    }

    /**
     * @Route("/admin/sites/new", name="site_new")
     */
    public function new(Request $request): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($site);
            $this->entityManager->flush();

            return $this->redirectToRoute('site_index');
        }

        return $this->render('admin/sites/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/sites/{id}/edit", name="site_edit")
     */
    public function edit(Request $request, Site $site): Response
    {
        $form = $this->createForm(SiteType::class, $site);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('site_index');
        }

        return $this->render('admin/sites/edit.html.twig', [
            'form' => $form->createView(),
            'site' => $site,
        ]);
    }

    /**
     * @Route("/admin/sites/{id}", name="site_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Site $site): Response
    {
        if ($this->isCsrfTokenValid('delete'.$site->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($site);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('site_index');
    }
}