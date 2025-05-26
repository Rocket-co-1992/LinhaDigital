namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Service\FeedbackService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    private $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    /**
     * @Route("/feedback", name="feedback_submit", methods={"POST"})
     */
    public function submitFeedback(Request $request): Response
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->feedbackService->saveFeedback($feedback);
            return $this->json(['message' => 'Feedback submitted successfully!'], Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/admin/feedback", name="admin_feedback_list", methods={"GET"})
     */
    public function listFeedback(): Response
    {
        $feedbacks = $this->feedbackService->getAllFeedback();
        return $this->render('admin/feedback/index.html.twig', [
            'feedbacks' => $feedbacks,
        ]);
    }

    /**
     * @Route("/admin/feedback/{id}/approve", name="admin_feedback_approve", methods={"POST"})
     */
    public function approveFeedback(int $id): Response
    {
        $this->feedbackService->approveFeedback($id);
        return $this->redirectToRoute('admin_feedback_list');
    }

    /**
     * @Route("/admin/feedback/{id}/delete", name="admin_feedback_delete", methods={"POST"})
     */
    public function deleteFeedback(int $id): Response
    {
        $this->feedbackService->deleteFeedback($id);
        return $this->redirectToRoute('admin_feedback_list');
    }
}