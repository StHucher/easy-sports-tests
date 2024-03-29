<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Tag $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Tag $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function allTestForPrimaryTag($primaryTag) {

        $conn = $this->getEntityManager()->getConnection();

        // une requete qui renvoit un title / slug aléatoire
        $sql = '
            SELECT test_tag.test_id 
            FROM tag 
            INNER JOIN test_tag
            ON tag.id = test_tag.tag_id
            where tag.name = "' . $primaryTag .'"';

        // exécution de la requete
        $results = $conn->executeQuery($sql);

        // returns an array (i.e. a raw data set)
        return $results->fetchAllAssociative();
    }


    public function allTagForPrimaryTag($primaryTag, $testId) {

        $conn = $this->getEntityManager()->getConnection();

        // une requete qui renvoit un title / slug aléatoire
        $sql = '
                SELECT *
                FROM tag
                INNER JOIN test_tag
                ON tag.id = test_tag.tag_id
                WHERE test_tag.test_id = "' . $testId .'" AND  tag.name != "' . $primaryTag .'"';

        // exécution de la requete
        $results = $conn->executeQuery($sql);

        // returns an array (i.e. a raw data set)
        return $results->fetchAllAssociative();

    }

}
