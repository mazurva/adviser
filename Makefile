run-tests: ; vendor/bin/phpunit
code-coverage: ; vendor/bin/phpunit --coverage-html=coverage/
boot-coverage-server: ; php -S localhost:8000 -t coverage/
boot-docs-server: ; php -S localhost:8000 -t docs/
build-phar: ; box build ; chmod +x builds/adviser.phar
build-docs: ; apigen generate
