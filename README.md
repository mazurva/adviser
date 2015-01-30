# Adviser [![Build Status](https://travis-ci.org/bound1ess/adviser.svg?branch=master)](https://travis-ci.org/bound1ess/adviser)

Adviser is a CLI application that checks your PHP project for various possible improvements.

Heavily inspired by [phppackagechecklist.com](http://phppackagechecklist.com).

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

### Building a PHAR

This is not very difficult to do either, just run:

```shell
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

![](http://i.imgur.com/zEHGkWZ.png)

Available formatters:

- `plaintext` (`Adviser\Output\Formatters\PlainTextFormatter`).

### analyse-repository name [--formatter="..."]

The `name` argument here is a Github repository name (e.g. `bound1ess/adviser`).
This command will make a local clone of it, run the `analyse` command, then remove it (directory).

![](http://i.imgur.com/j8Cthjc.png)

## Configuring

*Adviser* can be configured via an `adviser.yml` file, placed in the directory you run it in.

An example:

```yaml
# Add a new formatter.
formatters:
    - "Your\Custom\Formatter\ClassName"

# Add a new validator.
validators:
    - "Your\Custom\Validator\ClassName"

# Configure a validator.
Some\Validator\ClassName:
    - foo: 123
    - bar:
        - "baz"
```

## Extending

### Creating a new Validator

1. Create a new PHP class, just like that:

```php
use Adviser\Validators\AbstractValidator, Adviser\Validators\ValidatorInterface;

class YourValidator extends AbstractValidator
{
}

# If you don't want to extend AbstractValidator:

class YourValidator implements ValidatorInterface
{
}
```

2. Write the logic you need (Adviser's source code can help, it's *completely* tested and *decently* documented).
3. Don't forget to test it!
4. Add it to the `adviser.yml` configuration file (see [Configuring](#configuring)).
5. Done! Share it with others if you want to.

## Contributing

1. Fork the project and create a local clone of it.
2. Install the dependencies: `composer update` or `composer install --dev`.
3. Make a fix.
4. Run the tests: `make tests`. ![](http://i.imgur.com/1CZZw84.png)
5. Build the coverage report:

```shell
make code-coverage
make boot-server
```

Now open `localhost:8000` in your browser.
![](http://i.imgur.com/bmGTxz9.png)

6. Commit and pull!

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
