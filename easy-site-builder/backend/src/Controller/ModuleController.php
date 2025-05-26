namespace App\Controller;

use App\Entity\ModuleInstance;
use App\Form\ModuleInstanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/modules", name="module_index")
     */
    public function index(): Response
    {
        $modules = $this->entityManager->getRepository(ModuleInstance::class)->findAll();

        return $this->render('admin/modules/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/modules/new", name="module_new")
     */
    public function new(Request $request): Response
    {
        $moduleInstance = new ModuleInstance();
        $form = $this->createForm(ModuleInstanceType::class, $moduleInstance);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($moduleInstance);
            $this->entityManager->flush();

            return $this->redirectToRoute('module_index');
        }

        return $this->render('admin/modules/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modules/{id}/edit", name="module_edit")
     */
    public function edit(Request $request, ModuleInstance $moduleInstance): Response
    {
        $form = $this->createForm(ModuleInstanceType::class, $moduleInstance);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('module_index');
        }

        return $this->render('admin/modules/edit.html.twig', [
            'form' => $form->createView(),
            'module' => $moduleInstance,
        ]);
    }

    /**
     * @Route("/modules/{id}", name="module_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ModuleInstance $moduleInstance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moduleInstance->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($moduleInstance);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('module_index');
    }
}