<?php

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

require_once __DIR__ .'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements Context
{
    use KernelDictionary;

    private $currentUser;
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

        return $user;
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


    /**
     * @Given there are :count products
     */
    public function thereAreProducts($count)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        for ($i = 0; $i < $count; $i++ ) {
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setPrice(rand(10,100));
            $product->setDescription('lorem');
            $em->persist($product);
        }
        $em->flush();
    }

    /**
     * @Given I author :count products
     */
    public function iAuthorProducts($count)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        for ($i = 0; $i < $count; $i++ ) {
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setPrice(rand(10,100));
            $product->setDescription('lorem');
            $product->setAuthor($this->currentUser);
            $em->persist($product);
        }
        $em->flush();
    }

    /**
     * @When I click :linkText
     */
    public function iClick($linkText)
    {
        $this->getSession()->getPage()->clickLink($linkText);
    }

    /**
     * @Then I should see :count products
     */
    public function iShouldSeeProducts($count)
    {
        $table = $this->getSession()->getPage()->find('css', 'table.table');
        assertNotNull($table, 'could not find a table');
        assertCount(intval($count), $table->findAll('css', 'tbody tr'));

    }

    /**
     * @Given I login as an admin
     */
    public function iLoginAsAnAdmin()
    {
        $this->currentUser = $this->thereIsAnAdminUserWithPassword('admin', 'admin');
        $this->visitPath('/login');
        $this->getSession()->getPage()->findField('Username')->setValue('admin');
        $this->getSession()->getPage()->findField('Password')->setValue('admin');
        $this->getSession()->getPage()->pressButton('Login');

    }



}
