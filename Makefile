install:
	composer install

lint:
	./vendor/bin/phpcs

test:
	./vendor/bin/phpunit tests

test-coverage:
	./vendor/bin/phpunit tests --coverage-clover build/logs/clover.xml

.PHONY: install lint test test-coverage