<?php

namespace App\Controller;

use App\Entity\DemoInstance;
use App\Service\DemoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    private $demoService;

    public function __construct(DemoService $demoService)
    {
        $this->demoService = $demoService;
    }

    /**
     * @Route("/demos", name="demo_index", methods={"GET"})
     */
    public function index(): Response
    {
        $demos = $this->demoService->getAllDemos();
        return $this->render('admin/demos/index.html.twig', [
            'demos' => $demos,
        ]);
    }

    /**
     * @Route("/demos/new", name="demo_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $demoInstance = new DemoInstance();
        // Handle form submission and creation logic here

        return $this->render('admin/demos/new.html.twig', [
            'demo' => $demoInstance,
        ]);
    }

    /**
     * @Route("/demos/{id}", name="demo_show", methods={"GET"})
     */
    public function show(DemoInstance $demoInstance): Response
    {
        return $this->render('admin/demos/show.html.twig', [
            'demo' => $demoInstance,
        ]);
    }

    /**
     * @Route("/demos/{id}/edit", name="demo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DemoInstance $demoInstance): Response
    {
        // Handle form submission and update logic here

        return $this->render('admin/demos/edit.html.twig', [
            'demo' => $demoInstance,
        ]);
    }

    /**
     * @Route("/demos/{id}/delete", name="demo_delete", methods={"POST"})
     */
    public function delete(DemoInstance $demoInstance): Response
    {
        $this->demoService->deleteDemo($demoInstance);
        return $this->redirectToRoute('demo_index');
    }
}