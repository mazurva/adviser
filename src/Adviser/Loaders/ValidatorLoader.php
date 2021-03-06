<?php namespace Adviser\Loaders;

use Adviser\ConfigurationLoader;

class ValidatorLoader extends AbstractLoader
{

    /**
     * @var ConfigurationLoader
     */
    protected $loader;

    /**
     * @param ConfigurationLoader|null $loader
     * @return ValidatorLoader
     */
    public function __construct(ConfigurationLoader $loader = null)
    {
        $this->loader = $loader ?: new ConfigurationLoader();

        $this->checkForAutoloader();
    }

    /**
     * Load validators listed in the configuration file.
     *
     * @return array
     */
    public function loadFromConfigurationFile()
    {
        $configuration = $this->loader->load();
        $validators = [];

        foreach ($configuration["validators"] as $validator) {
            if (array_key_exists($validator, $configuration)) {
                $validators[] = new $validator(getcwd(), $configuration[$validator]);
            } else {
                $validators[] = new $validator(getcwd());
            }
        }

        return $validators;
    }

    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected function checkForAutoloader()
    {
        if (\Phar::running() and strpos(getcwd(), "projects/adviser") === false) {
            require getcwd()."/vendor/autoload.php";
        }
    }
}
