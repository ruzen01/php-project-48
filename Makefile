install:
	composer install

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
	vendor/bin/phpstan analyse src tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

test-coverage-text:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-text

.PHONY: install lint lint-fix test test-coverage test-coverage-text