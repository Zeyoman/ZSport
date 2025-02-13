<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Video>
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    public function findVideosWithSameTheme($theme, $currentVideoId)
    {
        return $this->createQueryBuilder('v')
            ->where('v.theme = :theme')
            ->andWhere('v.id != :currentVideoId')
            ->setParameter('theme', $theme)
            ->setParameter('currentVideoId', $currentVideoId)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * Retourne les vidéos les plus regardées, limité à $limit.
    //  *
    //  * @param int $limit
    //  * @return Video[]
    //  */
    // public function findTopViewedVideos(int $limit = 3): array
    // {
    //     return $this->createQueryBuilder('v')
    //         ->orderBy('v.view', 'DESC')
    //         ->setMaxResults($limit)
    //         ->getQuery()
    //         ->getResult();
    // }
    //    /**
    //     * @return Video[] Returns an array of Video objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Video
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
