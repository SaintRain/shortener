<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RedirectRule;
use AppBundle\Form\Type\RedirectRuleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\{
    HttpFoundation\Request, Routing\Annotation\Route, HttpKernel\Exception\NotFoundHttpException
};
use Pagerfanta\{
    Pagerfanta, Adapter\DoctrineORMAdapter, View\TwitterBootstrap4View
};


class DefaultController extends Controller
{

    CONST MAX_PER_PAGE = 20;

    /**
     * @Route("/", name="homepage", methods={"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $redirectRule = new RedirectRule();
        $form = $this->createForm(RedirectRuleType::class, $redirectRule);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($redirectRule);
                $em->flush();

                return $this->redirectToRoute('success', ['slug' => $redirectRule->getSlug()]);
            }
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/success/{slug}", name="success", methods={"GET"}, requirements={"slug" = "[a-zA-Z0-9_-]{1,7}"})
     */
    public function successAction(Request $request, $slug)
    {
        if ($redirectRule = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:RedirectRule')->findOneBySlug($slug)) {

            return $this->render('default/success.html.twig', [
                'url' => $this->get('slug_service')->getRedirectUrl($redirectRule),
                'urlTransitions' => $this->get('slug_service')->getTransitionsUrl($redirectRule)
            ]);

        } else {
            throw new NotFoundHttpException('Page not found');
        }
    }

    /**
     * @Route("/{slug}", name="redirect", methods={"GET"}, requirements={"slug" = "[a-zA-Z0-9_-]{1,7}"})
     */
    public function redirectAction(Request $request, $slug)
    {
        if ($redirectRule = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:RedirectRule')->findActiveBySlug($slug)) {

            $this->get('transition_service')->save($request, $redirectRule);
            return $this->redirect($redirectRule->getUrl());

        } else {
            throw new NotFoundHttpException('Page not found.');
        }
    }


    /**
     * @Route("/{slug}/transitions/{page}", name="view_transitions", methods={"GET"}, defaults={"page":1},
     *     requirements={"slug" = "[a-zA-Z0-9_-]{1,7}", "page" = "\d+"})
     */
    public function transitionsAction(Request $request, $slug, $page)
    {

        if ($redirectRule = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:RedirectRule')->findActiveBySlug($slug)) {

            $queryBuilder = $this->getDoctrine()->getRepository('AppBundle:Transition')->getQueryBuilder($redirectRule);

            $adapter = new DoctrineORMAdapter($queryBuilder);
            $pagerfanta = new Pagerfanta($adapter);
            $pagerfanta->setMaxPerPage($this::MAX_PER_PAGE);
            $pagerfanta->setCurrentPage($page);
            $transitions = $pagerfanta->getCurrentPageResults();

            $view = new TwitterBootstrap4View();
            $paginationHtml = $view->render($pagerfanta, function ($page) use ($slug) {
                return $this->generateUrl('view_transitions', ['slug' => $slug, 'page' => $page]);
            });

            return $this->render('default/transitions.html.twig', [
                'transitions' => $transitions,
                'paginationHtml' => $paginationHtml,
                'url' => $this->get('slug_service')->getRedirectUrl($redirectRule),
                'pagerfanta' => $pagerfanta
            ]);

        } else {
            throw new NotFoundHttpException('Page not found');
        }
    }
}
