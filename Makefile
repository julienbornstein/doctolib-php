.PHONY: tests format
.DEFAULT_GOAL= help

help:
	@grep -E '(^[0-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-25s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

format: ## format the code
	vendor/bin/php-cs-fixer fix

test: ## test the code
	composer validate --no-check-publish --ansi
	vendor/bin/php-cs-fixer fix --dry-run --diff --ansi
	vendor/bin/phpstan analyze --memory-limit=-1 --ansi
	vendor/bin/phpunit -d memory_limit=-1 --colors=always --coverage-html build/logs/phpunit/coverage-report
	vendor/bin/phpmd src text ruleset.xml --suffixes php
