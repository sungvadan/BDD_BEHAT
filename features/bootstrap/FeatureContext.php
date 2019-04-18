<?php

use AppBundle\Entity\User;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

require_once __DIR__ .'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    use KernelDictionary;

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
     * @Given there is an admin user :userName with password :password
     */
    public function thereIsAnAdminUserWithPassword($userName, $password)
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setPlainPassword($password);
        $user->setRoles(array('ROLE_ADMIN'));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($em);
        $purger->purge();

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
