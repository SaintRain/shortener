<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RedirectRuleRepository extends EntityRepository
{

    public function findActiveBySlug($slug)
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.slug=:slug AND (r.expired IS NULL OR r.expired>CURRENT_TIMESTAMP())')
            ->setParameter('slug', $slug)->getQuery()->getOneOrNullResult();
    }


}


