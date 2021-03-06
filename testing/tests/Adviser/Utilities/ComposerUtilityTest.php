<?php namespace Adviser\Utilities;

class ComposerUtilityTest extends \Adviser\Testing\UtilityTestCase
{

    /**
     * @test
     */
    public function it_checks_if_the_manifest_file_exists()
    {
        $composer = new ComposerUtility();

        $this->assertTrue($composer->manifestExists(ADVISER_DIR));
        $this->assertFalse($composer->manifestExists($_SERVER["HOME"]));
    }

    /**
     * @test
     */
    public function it_checks_if_the_manifest_file_is_valid()
    {
        $runner = $this->mockUtility("CommandRunner");

        $runner->shouldReceive("run")
               ->twice()
               ->with("composer validate")
               ->andReturn(
                   ["stdout" => "./composer.json is valid".PHP_EOL],
                   ["stdout" => "./composer.json is invalid"]
               );

        $composer = new ComposerUtility($runner);

        $this->assertTrue($composer->isManifestValid(ADVISER_DIR));
        $this->assertFalse($composer->isManifestValid(ADVISER_DIR));
    }

    /**
     * @test
     */
    public function it_checks_if_given_autoloader_was_configured_in_the_manifest_file()
    {
        $composer = new ComposerUtility();

        $this->assertFalse($composer->hasAutoloader(ADVISER_DIR, "psr-0"));
        $this->assertTrue($composer->hasAutoloader(ADVISER_DIR, "psr-4"));

        $this->assertEquals($composer->hasAutoloader($_SERVER["HOME"], "psr-4"), null);
    }

    /**
     * @test
     */
    public function it_returns_the_source_directories_listed_in_the_manifest_file()
    {
        $composer = new ComposerUtility();

        $this->assertCount(0, $composer->getSourceDirectories($_SERVER["HOME"]));
        $this->assertEquals($composer->getSourceDirectories(ADVISER_DIR), ["src/Adviser/"]);
    }

    /**
     * @test
     */
    public function it_returns_the_dependencies_listed_in_the_manifest_file()
    {
        $composer = new ComposerUtility();

        $this->assertCount(0, $composer->getDependencies($_SERVER["HOME"]));

        // Only include the "require" section.
        $this->assertContains("symfony/console", $composer->getDependencies(ADVISER_DIR));

        // Include the "require-dev" section as well.
        $this->assertContains(
            "phpunit/phpunit", $composer->getDependencies(ADVISER_DIR, true)
        );
    }
}
