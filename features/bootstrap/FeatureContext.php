<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

require_once __DIR__ .'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
/**
 * Defines application features from the specific context.
 */
class FeatureContext  implements Context
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


}
