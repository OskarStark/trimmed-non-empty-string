# vim: set tabstop=8 softtabstop=8 noexpandtab:
phpstan:
	docker run --rm -it -w=/app -v ${PWD}:/app oskarstark/phpstan-ga:latest analyse src/ --level=max

cs:
	docker run --rm -it -w /app -v ${PWD}:/app oskarstark/php-cs-fixer-ga:2.18.2

test:
	php vendor/bin/phpunit -v
