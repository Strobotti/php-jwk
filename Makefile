test-unit:
	php -d xdebug.mode=coverage ./vendor/bin/phpunit

php-cs-fixer:
	./vendor/bin/php-cs-fixer fix --verbose --dry-run --show-progress none --config .php_cs.php

php-cs-fixer-fix:
	./vendor/bin/php-cs-fixer fix --verbose --show-progress none --config .php_cs.php
