<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index()
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
        ]);
    }

    /**
     * @Route("/demo/a", name="ademo", methods={"GET","POST"})
     */
    public function a()
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'aDemoController',
        ]);
    }

    /**
     * @Route("/demo/b", name="bdemo", methods={"GET","POST"})
     */
    public function b()
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'bDemoController',
        ]);
    }

    /**
     * @Route("/demo/c", name="cdemo", methods={"GET","POST"})
     */
    public function c()
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'cDemoController',
        ]);
    }

    /**
     * @Route("/demo/d", name="ddemo", methods={"GET","POST"})
     */
    public function d()
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'dDemoController',
        ]);
    }

}
