<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Routing\Annotation\Route;

//https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => '首页',
        ]);
    }
}
