<?php

namespace Acme\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Application\Sonata\UserBundle\Entity\User;
use Acme\ApiBundle\Entity\Client;
class LoadBasicData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
     /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {

        $admin = new User();
        $admin->addRole('ROLE_SUPER_ADMIN');
        $admin->setUserName('admin');
        $admin->setEmail('admin@symfony.com');
        $admin->setPlainPassword('1234');
        $admin->setEnabled(true);
        $manager->persist($admin);
        $client = new Client();
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array("localhost.symfony"));
        $client->setAllowedGrantTypes(array("password"));
        $clientManager->updateClient($client);
        $client->setRandomId("3k4bi41kkhesgcookw0sgsw8skck4g8sowoc8oos8c844cccs8");
        $client->setSecret("426gpvs6ka80oocsww0s8osgcc8w8sk4oswwoo8440c4cc4kg4");
        $manager->flush();   
    }

    function getOrder()
    {
        return 1;
    } 
}