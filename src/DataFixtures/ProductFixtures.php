<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setTitle('testTitle');
        $product->setSummary('I am summary');
        $manager->persist($product);
        $manager->flush();
    }
}
