<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\BackendUser;


class BackendUserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new BackendUser();
        $user->setUuid('sdfsdfsdf');
        $user->setUsername('ssa');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '123456'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
