<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\PostMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostMeta>
 *
 * @method PostMeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostMeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostMeta[]    findAll()
 * @method PostMeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostMetaRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry;
        parent::__construct($registry, PostMeta::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PostMeta $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function update(array $data): void
    {
        $entityManager = $this->em->getManager();
        $PostMeta = $this->em->getRepository(PostMeta::class)->findOneBy([
            'post' => $data['post_id'],
            'meta_key' => $data['meta_key'],
        ]);

        if (!$PostMeta) {
            throw $this->createNotFoundException(
                'No PostMeta found.'
            );
        }

        $PostMeta->setMetaValue($data['meta_value']);
        $entityManager->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PostMeta $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PostMeta[] Returns an array of PostMeta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostMeta
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
