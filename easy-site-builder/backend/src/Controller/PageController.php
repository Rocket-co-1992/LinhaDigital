namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    private $entityManager;
    private $pageRepository;

    public function __construct(EntityManagerInterface $entityManager, PageRepository $pageRepository)
    {
        $this->entityManager = $entityManager;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Route("/admin/pages", name="page_index")
     */
    public function index(): Response
    {
        $pages = $this->pageRepository->findAll();

        return $this->render('admin/pages/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/admin/pages/new", name="page_new")
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($page);
            $this->entityManager->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('admin/pages/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/pages/{id}/edit", name="page_edit")
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('admin/pages/edit.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/admin/pages/{id}/delete", name="page_delete")
     */
    public function delete(Page $page): Response
    {
        $this->entityManager->remove($page);
        $this->entityManager->flush();

        return $this->redirectToRoute('page_index');
    }
}