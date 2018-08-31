<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\RedirectRule;
use Doctrine\ORM\EntityRepository;

class TransitionRepository extends EntityRepository
{

    public function getQueryBuilder(RedirectRule $redirectRule)
    {
        return $this->createQueryBuilder('t')
            ->where('t.redirectRule=:redirectRule')
            ->setParameter('redirectRule', $redirectRule->getId())
            ->orderBy('t.id', 'desc')
            ->getQuery();
    }

}


