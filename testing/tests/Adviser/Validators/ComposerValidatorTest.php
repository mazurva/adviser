<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class ComposerValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new ComposerValidator(null);
        $this->mockUtilities($validator);

        // Test.
        // 1st scenario: the manifest was not found/invalid.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertCount(1, $messages->getAll());

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // 2nd scenario: the manifest file (composer.json) is fine, everything else is not.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertCount(3, $messages->getAll());
        
        foreach ($messages->getAll() as $message) {
            $this->assertEquals($message->getLevel(), Message::WARNING);
        }

        // 3rd scenario: the manifest is fine, so is everything else.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertCount(3, $messages->getAll());

        foreach ($messages->getAll() as $message) {
            $this->assertEquals($message->getLevel(), Message::NORMAL);
        }
    }

    protected function mockUtilities(ComposerValidator $validator)
    {
        $packagist = Mockery::mock("Adviser\Utility\Packagist");

        // We actually don't want to hit the Packagist API in our tests, so we use mocks.
        // We'll be called in "ComposerValidator::checkIfPackageWasPublished".
        $packagist->shouldReceive("packageExists")
                  ->twice()
                  ->with("test/package")
                  ->andReturn(false, true);


        $composer = Mockery::mock("Adviser\Utility\Composer");

        // We need to mock these 3 methods for "ComposerValidator::isManifestOK".
        $composer->shouldReceive("readManifest")
                 ->twice()
                 ->with(null)
                 ->andReturn(["name" => "test/package"]);

        $composer->shouldReceive("isManifestValid")
                 ->twice()
                 ->with(null)
                 ->andReturn(false, true);

        $composer->shouldReceive("manifestExists")
                 ->times(3)
                 ->with(null)
                 ->andReturn(false, true, true);

        // This one is for "ComposerValidator::lookForAutoloader".
        $composer->shouldReceive("hasAutoloader")
                 ->twice()
                 ->with(null, "psr-4")
                 ->andReturn(false, true);

        // And this is for "ComposerValidator::checkIfSourceCodeIsStoredIn".
        $composer->shouldReceive("getSourceDirectories")
                 ->twice()
                 ->with(null)
                 ->andReturn(false, true);


        $validator->utility("Packagist", $packagist);
        $validator->utility("Composer", $composer);
    }
}
