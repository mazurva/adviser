# Adviser [![Build Status](https://travis-ci.org/bound1ess/adviser.svg?branch=master)](https://travis-ci.org/bound1ess/adviser)

Adviser is a CLI application that checks your PHP project for various possible improvements.

Heavily inspired by [phppackagechecklist.com](http://phppackagechecklist.com).

## Motivation

- Do I have some sort of a license file?
- Is my composer.json valid?
- Is my code PSR-2 compatible?
- Are the repository tags and settings OK?

I often ask myself such questions.
And I got tired of checking it all manually every time.
Here comes Adviser to make things a lot easier.

## Navigation

- [Installing](#installing)
- [Using](#using)
- [Configuring](#configuring)
- [Extending](#extending)
- [Contributing](#contributing)
- [Additional information](#additional-information)

## Installing

### Composer way

Just run in your terminal (you should be in your project's root directory):

```shell
composer require --dev bound1ess/adviser
```

Or, if you don't have *Composer* installed globally:

```shell
curl -sS https://getcomposer.org/installer | php
./composer.phar require --dev bound1ess/adviser
```

Now you should be able to run `vendor/bin/adviser` and see Adviser's CLI.

### Building a PHAR (Box is required)

This is not very difficult to do either, just run:

```shell
box --version
git clone https://github.com/bound1ess/adviser.git
cd adviser
composer update # Assuming that it's installed globally.
make build-phar
```

![](http://i.imgur.com/GSDqCYc.png)

Now you can use `builds/adviser.phar`, or (only if you want to!) you can also do this:

```shell
sudo mv builds/adviser.phar /usr/local/bin/adviser
```

Now you can use `adviser` (everywhere!) instead of `builds/adviser.phar`.

## Using

### analyse

This command will analyse (*suggest possible improvements*) the current working directory.

![](http://i.imgur.com/GylrC0R.png)

### analyse --formatter="formattername"

Same, but the output will be formatted depending on the formatter you choose.

![](http://i.imgur.com/9FqeIkR.png)

Available formatters:

- `plaintext` (`Adviser\Output\Formatters\PlainTextFormatter`).

### analyse-repository name [--formatter="..."]

The `name` argument here is a Github repository name (e.g. `bound1ess/adviser`).
This command will make a local clone of it, run the `analyse` command, then remove it (directory).

![](http://i.imgur.com/59kfBcc.png)

## Configuring

*Adviser* can be configured via an `adviser.yml` file placed in the working directory.

### Adding a Formatter

```yaml
# Add a new formatter.
formatters:
    - "Your\Custom\Formatter\ClassName"
    # ...
```

### Adding a Validator

```yaml
# Add a new validator.
validators:
    - "Your\Custom\Validator\ClassName"
    # ...
```

### Configuring a Validator

#### ChangelogValidator

```yaml
Adviser\Validators\ChangelogValidator:
    files:
        - "CHANGELOG.md"
        # ...
```

#### CIValidator

```yaml
Adviser\Validators\CIValidator:
    allowedVersions:
        - "5.6"
        - "5.5"
        - "5.4"
        - "hhvm"
        # ...
```

#### ComposerValidator

```yaml
Adviser\Validators\ComposerValidator:
    autoloader: "psr-4"
    source_directory: "src"
```

#### ContributingValidator

```yaml
Adviser\Validators\ContributingValidator:
    files:
        - "CONTRIBUTING.md"
        # ...
```

#### FrameworkValidator

```yaml
Adviser\Validators\FrameworkValidator:
    frameworks:
        - "laravel/framework"
        # ...
```

#### LicenseValidator

```yaml
Adviser\Validators\LicenseValidator:
    files:
        - "LICENSE.md"
        # ...
```

#### ReadmeValidator

```yaml
Adviser\Validators\ReadmeValidator:
    files:
        - "README.md"
        # ...
```

#### TestValidator

```yaml
Adviser\Validators\TestValidator:
    frameworks:
        - "phpunit/phpunit"
        # ...
    frameworkToFiles:
        phpunit/phpunit:
            - "phpunit.xml"
            - "phpunit.xml.dist"
            # ...
        # ...
```

## Extending

1. Write the code.
2. Don't forget to test it!
3. Add it to the `adviser.yml` configuration file (see [Configuring](#configuring) section).
4. Done! Share your work with others if you want to.

### Creating a Validator

```php
class YourValidator extends \Adviser\Validators\AbstractValidator
{

    /**
     * @return \Adviser\Output\MessageBag
     */
    public function handle()
    {
        // @todo
    }
}
```

### Creating a Formatter

```php
use Adviser\Output\MessageBag;

class YourFormatter extends \Adviser\Output\Formatters\AbstractFormatter
{

    /**
     * @param MessageBag $bag
     * @return string
     */
    public function format(MessageBag $bag)
    {
        // @todo
    }
}
```

## Contributing

1. Fork the project and create a local clone of it.
2. Install the dependencies: `composer update` or `composer install --dev`.
3. Make a fix.
4. Run the tests: `make tests`. 

![](http://i.imgur.com/u2ofyLc.png)

5. Build the coverage report:

```shell
make code-coverage
make boot-server
```

Now open `localhost:8000` in your browser.
![](http://i.imgur.com/1nPU5Uu.png)

6. Commit and pull!

### Extra: building the documentation (ApiGen is required)

```shell
apigen --version
make build-docs boot-docs-server
```

## Additional information

License and support information, as well as my thanks to everyone who made *Adviser* possible.

### License

This project is licensed under *the MIT license*.

### Support

Stuck?
Found a bug?
Feel free to create a new issue here on *Github*, or find me on [Twitter](https://twitter.com/bound1ess).

### Thanks!

To the creators of *PHPUnit*, *Symfony*, *Guzzle*, *Mockery* and *Box* projects.
