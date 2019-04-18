<?php

use AppBundle\Entity\User;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;

require_once __DIR__ .'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    private static $container;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    /**
     * @BeforeSuite
     */
    public static function bootstrapSymfony()
    {
        require __DIR__.'/../../app/autoload.php';
        require __DIR__.'/../../app/AppKernel.php';

        $kernel = new AppKernel('test', true);
        $kernel->boot();

        self::$container = $kernel->getContainer();

    }

    /**
     * @Given there is an admin user :userName with password :password
     */
    public function thereIsAnAdminUserWithPassword($userName, $password)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setPlainPassword($password);
        $user->setRoles(array('ROLE_ADMIN'));

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
    }


    /**
     * @When I fill in search box with :term
     */
    public function iFillInSearchBoxWith($term)
    {
        // name = "searchTerm"
        $searchBox =$this->getSession()
            ->getPage()
            ->find('css', '[name="searchTerm"]');

        assertNotNull($searchBox, 'The search box was not found');

        $searchBox->setValue($term);
    }

    /**
     * @When I press the search button
     */
    public function iPressTheSearchButton()
    {
        $searchBox =$this->getSession()
            ->getPage()
            ->find('css', '#search_submit');

        assertNotNull($searchBox, 'The search button was not found');

        $searchBox->press();
    }



}
