<?php

namespace AppBundle\Services;

use AppBundle\Entity\Transition;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\RedirectRule;
use MaxMind\Db\Reader;

class TransitionService
{

    private $em;
    private $geoip;

    public function __construct(EntityManager $em, Reader $geoip)
    {
        $this->em = $em;
        $this->geoip = $geoip;
    }

    public function save(Request $request, RedirectRule $redirectRule)
    {

        $geography = $this->geoip->get($request->getClientIp());
        $iso = $geography['country']['iso_code'] ?? '';
        $transition = new Transition();
        $transition->setRedirectRule($redirectRule);
        $transition->setIp($request->getClientIp());
        $transition->setUserAgent($request->headers->get('User-Agent'));
        $transition->setIsoCode($iso);
        $this->em->persist($transition);
        $this->em->flush();
    }

}