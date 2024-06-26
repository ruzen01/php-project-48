install:
	composer install

lint: 
	composer lint

test-coverage:
   XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-clover build/logs/clover.xml