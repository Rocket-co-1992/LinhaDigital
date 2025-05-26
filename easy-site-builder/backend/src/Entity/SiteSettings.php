namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteSettingsRepository")
 */
class SiteSettings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="settings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $favicon;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $recaptchaKeys = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gaId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $seoMeta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $feedbackAutoPublish;

    /**
     * @ORM\Column(type="integer")
     */
    private $demoDurationDefault;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFavicon(): ?string
    {
        return $this->favicon;
    }

    public function setFavicon(?string $favicon): self
    {
        $this->favicon = $favicon;

        return $this;
    }

    public function getRecaptchaKeys(): ?array
    {
        return $this->recaptchaKeys;
    }

    public function setRecaptchaKeys(array $recaptchaKeys): self
    {
        $this->recaptchaKeys = $recaptchaKeys;

        return $this;
    }

    public function getGaId(): ?string
    {
        return $this->gaId;
    }

    public function setGaId(?string $gaId): self
    {
        $this->gaId = $gaId;

        return $this;
    }

    public function getSeoMeta(): ?string
    {
        return $this->seoMeta;
    }

    public function setSeoMeta(?string $seoMeta): self
    {
        $this->seoMeta = $seoMeta;

        return $this;
    }

    public function getFeedbackAutoPublish(): ?bool
    {
        return $this->feedbackAutoPublish;
    }

    public function setFeedbackAutoPublish(bool $feedbackAutoPublish): self
    {
        $this->feedbackAutoPublish = $feedbackAutoPublish;

        return $this;
    }

    public function getDemoDurationDefault(): ?int
    {
        return $this->demoDurationDefault;
    }

    public function setDemoDurationDefault(int $demoDurationDefault): self
    {
        $this->demoDurationDefault = $demoDurationDefault;

        return $this;
    }
}