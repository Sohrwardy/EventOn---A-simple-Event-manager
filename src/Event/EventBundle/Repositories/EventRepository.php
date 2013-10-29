<?php

namespace Event\EventBundle\Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    public function getUpcomingEvents()
    {
        return $this
            ->createQueryBuilder('e')
            ->addOrderBy('e.time', 'ASC')
            ->andWhere('e.time > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }


    public function getRecentlyUpdatedEvents()
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.updated > :since')
            ->setParameter('since', new \DateTime('24 hours ago'))
            ->getQuery()
            ->execute();
    }
}
