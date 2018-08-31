<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\RedirectRule;
use AppBundle\Services\SlugService;
use Doctrine\Common\EventSubscriber;

class RedirectRuleSubscriber implements EventSubscriber
{
    private $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof RedirectRule && !$entity->getSlug()) {
            $entity->setSlug($this->slugService->generateSlug());
        }
    }


}