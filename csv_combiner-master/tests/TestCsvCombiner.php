<?php
use Combiner\CsvCombiner;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class TestCsvCombiner extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var \Symfony\Component\Console\Command\Command
     */
    protected $command;

    /**
     * @var CommandTester
     */
    protected $commandTester;

    /**
     * Setup common variables for testing.
     */
    public function setUp()
    {
        $this->app = new Application();
        $this->app->add(new CsvCombiner());

        $this->command = $this->app->find('csv');
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * Test that the command will not execute if actual files aren't passed to it.
     */
    public function testTheCommandWillFailWithoutRealFileParameters()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'files' => ['one', 'two', 'three']
        ]);

        $expected = 'Invalid file';
        $actual = $this->commandTester->getDisplay();

        $this->assertContains($expected, $actual);
    }

    /**
     * Note that verifying the actual output is difficult as it is posted via fpassthru and can't be captured
     * by the typical `getDisplay()` method. Verify by output buffering.
     */
    public function testTheCommandWillRunGivenRealFileParameters()
	{
		ob_start();
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'files' => ['csv-combiner/fixtures/accessories.csv']
		]);

		$actual = ob_get_contents();
		ob_end_clean();

		$this->assertContains('b9f6f22276c919da793da65c76345ebb0b072257d12402107d09c89bc369a6b6,Satchels,accessories.csv', $actual);
		$this->assertContains('3b13daf29e360d56a4e80046c763bd925b8cbe60870d5c2c56b78d88db30d032,Satchels,accessories.csv', $actual);
    }
}

