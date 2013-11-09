<?php

namespace Riaf\Bundle\AnondBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Riaf\Bundle\AnondBundle\Entity\Post;

class DiaryController extends Controller
{
    /**
     * @Route("/", name="diary_index")
     * @Template
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $paginator = $this->get('knp_paginator');
        $request = $this->get('request');

        $postRepository = $doctrine->getRepository('RiafAnondBundle:Post');

        $q = $postRepository->getQueryAll();
        $pagination = $paginator->paginate($q, $request->query->get('page', 1), 10);

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/new", name="diary_new")
     * @Template
     */
    public function newAction()
    {
        $doctrine = $this->getDoctrine();
        $request = $this->get('request');

        $form = $this->createFormBuilder($post = new Post)
            ->add('subject')
            ->add('body', 'textarea', ['attr' => ['rows' => 10]])
            ->add('save', 'submit')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $doctrine->getManager();

            try {
                $em->persist($post);
                $em->flush();

                return $this->redirect($this->generateUrl('diary_index', [], true));
            } catch (\Exception $e) {
                // TODO: logging
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{id}", name="diary_show", requirements={"id" = "\d+"})
     * @ParamConverter("post", class="RiafAnondBundle:Post")
     * @Template
     */
    public function showAction(Post $post)
    {
        return [
            'post' => $post,
        ];
    }
}
