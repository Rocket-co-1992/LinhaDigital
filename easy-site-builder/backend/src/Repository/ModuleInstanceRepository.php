namespace App\Repository;

use App\Entity\ModuleInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ModuleInstanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleInstance::class);
    }

    public function findByPageId($pageId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.page = :pageId')
            ->setParameter('pageId', $pageId)
            ->orderBy('m.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findActiveModules()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.isActive = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }
}