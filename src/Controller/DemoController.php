<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\Packages;

use Symfony\Component\Asset\Context\RequestStackContext;

use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;





use Symfony\Contracts\Translation\TranslatorInterface;




class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index()
    {
 
        //基本用法
        //$package = new Package(new EmptyVersionStrategy()); // 无版本
        //$package = new Package(new StaticVersionStrategy('v1', '%s?version=%s')); //后缀方式
        $package = new Package(new StaticVersionStrategy('v1', '%2$s/%1$s')); //path方式
        echo $package->getUrl('image.png');


        //加path
        //$package = new PathPackage('/static/images', new StaticVersionStrategy('v1', '%s?version=%s'));
        //echo $package->getUrl('logo.png');


        //加CDNs
        /*
        $package = new UrlPackage(
            '//static.example.com/images/',
            new StaticVersionStrategy('v1', '%s?version=%s')
        );
        $package = new UrlPackage(
            array(
                '//static1.example.com/images/',
                '//static2.example.com/images/',
            ),
            new StaticVersionStrategy('v1', '%s?version=%s')
        );
        echo $package->getUrl('logo.png');
        */


        //根据访问自动选择http或https
        /*
        $package = new UrlPackage(
            array('http://example.com/', 'https://example.com/'),
            new StaticVersionStrategy('v1'),
            new RequestStackContext($requestStack)
        ); 
        echo $package->getUrl('logo.png');
        */


        //package分类
        /*
        $versionStrategy = new StaticVersionStrategy('v1');
        $defaultPackage = new Package($versionStrategy);
        $namedPackages = array(
            'img' => new UrlPackage('http://img.example.com/', $versionStrategy),
            'doc' => new PathPackage('/somewhere/deep/for/documents/', $versionStrategy),
        );
        $packages = new Packages($defaultPackage, $namedPackages);
        echo $packages->getUrl('main.css');
        // result: /main.css?v1
        echo $packages->getUrl('logo.png', 'img');
        // result: http://img.example.com/logo.png?v1
        echo $packages->getUrl('resume.pdf', 'doc');
        // result: /somewhere/deep/for/documents/resume.pdf?v1
        */


        return new Response();
    }

    /**
     * @Route("/demo/trans", name="demo_trans")
     */
    public function trans(TranslatorInterface $translator)
    {

        $translated = $translator->trans('Symfony is great');

        return $this->render('demo/trans.html.twig', [
            'translated' => $translated,
        ]);
    }
}
