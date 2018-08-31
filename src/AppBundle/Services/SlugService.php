<?php

namespace AppBundle\Services;

use AppBundle\Entity\RedirectRule;
use PUGX\Shortid\Shortid;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SlugService
{

    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function generateSlug()
    {
        return Shortid::generate();
    }

    public function getRedirectUrl(RedirectRule $redirectRule)
    {
        return $this->router->generate('redirect',
            ['slug' => $redirectRule->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);

    }

    public function getTransitionsUrl(RedirectRule $redirectRule)
    {
        return $this->router->generate('view_transitions',
            ['slug' => $redirectRule->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);
    }

}