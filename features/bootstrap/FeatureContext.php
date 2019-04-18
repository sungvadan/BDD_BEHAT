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
     * @BeforeScenario
     */
    public function moveIntoTestDir()
    {
        mkdir('test');
        chdir('test');
    }

    /**
     * @AfterScenario
     */
    public function moveOutDirTest()
    {
        chdir('..');
        if (is_dir('test')) {
           system('rm -r '.realpath('test'));
        }
    }


    /**
     * @Given There is a file named :name
     */
    public function thereIsAFileNamed($name)
    {
        touch($name);
    }

    /**
     * @When I run command :command
     */
    public function iRunCommand($command)
    {
        $this->output = shell_exec($command);
    }

    /**
     * @Then I should see :string in the output
     */
    public function iShouldSeeInTheOutput($string)
    {
        assertContains(
          $string,
          $this->output,
          sprintf('the file %s is not found in the output %s ', $string, $this->output)
        );
    }

    /**
     * @Given There is a dir named :dir
     */
    public function thereIsADirNamed($dir)
    {
        mkdir($dir);
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
