<?php
/**
 * Created by PhpStorm.
 * User: shibly
 * Date: 10/24/13
 * Time: 2:54 PM
 */
namespace Event\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Event\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\DataFixtures\Doctrine\Common\Persistence\ObjectManager|\Doctrine\Common\Persistence\ObjectManager $manager
     */

    private $container;

    function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('shibly');
        $user->setPassword($this->encodePassword($user, 'user'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->encodePassword($user, 'admin'));
        $manager->persist($admin);


        $manager->flush();


    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());

    }
}