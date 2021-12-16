test:
	./vendor/bin/phpunit -c .

test_debug:
	xdebug ./vendor/bin/phpunit -c .