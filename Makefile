SHELL = /bin/bash
.DEFAULT_GOAL := all
HERE := $(dir $(realpath $(firstword $(MAKEFILE_LIST))))

# https://mwop.net/blog/2023-12-11-advent-makefile.html
##@ help
help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[0-9a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

.PHONY: all
all: style analyze lint tests

# ### #

.PHONY: style
style: ## Fix any style issues
	@echo
	@echo "--> Style: php-cs-fixer"
	vendor/bin/php-cs-fixer fix -v
	@echo

.PHONY: lint
lint: ## Check if the code is valid
	@echo
	@echo "--> Lint"
	php -l src/josephscott/amulet.php
	php -l src/josephscott/amulet-response.php
	@echo

.PHONY: analyze
analyze: ## Static analysis, catch problems in code
	@echo
	@echo "--> Analyze: PHPStan"
	vendor/bin/phpstan

.PHONY: tests
tests: test-server ## Pest tests
	@echo
	@echo "--> Tests: Pest"
	@echo
	# Always stop the web server, even if tests fail
	# bash -c "./vendor/bin/pest --parallel || kill -9 `cat tests/server/pid.txt`"
	bash -c "./vendor/bin/pest || kill -9 `cat tests/server/pid.txt`"
	@echo
	@echo "--> Test Server: stopping"
	@echo
	kill -9 `cat tests/server/pid.txt`

.PHONY: test-server
test-server:
	@echo
	@echo "--> Test Server: starting"
	@echo
	nohup php -S 127.0.0.1:7878 -t tests/server > /dev/null 2>&1 & echo "$$!" > tests/server/pid.txt
