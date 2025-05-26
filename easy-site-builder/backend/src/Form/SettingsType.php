namespace App\Form;

use App\Entity\SiteSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Site Title',
            ])
            ->add('favicon', TextType::class, [
                'label' => 'Favicon URL',
            ])
            ->add('recaptcha_keys', TextareaType::class, [
                'label' => 'reCAPTCHA Keys',
            ])
            ->add('ga_id', TextType::class, [
                'label' => 'Google Analytics ID',
            ])
            ->add('seo_meta', TextareaType::class, [
                'label' => 'SEO Meta Tags',
            ])
            ->add('feedback_auto_publish', CheckboxType::class, [
                'label' => 'Automatically Publish Feedback',
                'required' => false,
            ])
            ->add('demo_duration_default', TextType::class, [
                'label' => 'Default Demo Duration (in days)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteSettings::class,
        ]);
    }
}