<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;

require_once __DIR__ .'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    private $output;

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
