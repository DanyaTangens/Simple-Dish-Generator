include .env

MYSQL_DUMPS_DIR=data/db/dumps

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  apidoc              Generate documentation of API"

	@echo "  composer-up         Update PHP dependencies with composer"
	@echo "  start        Create and start containers"
	@echo "  stop         Stop and clear all services"
	@echo "  logs                Follow log output"
	@echo "  phpmd               Analyse the API with PHP Mess Detector"

init:
	@$(shell cp -n $(shell pwd)/web/app/composer.json.dist $(shell pwd)/web/app/composer.json 2> /dev/null)

composer-up:
	@docker run --rm -v $(shell pwd)/web/app:/app composer update

restart:
	@make stop
	@make start

start: init
	@docker-compose up -d
	@make composer-up
	@make migrate

stop:
	@docker-compose down -v

logs:
	@docker-compose logs -f

migrate:
	@docker-compose exec -T php sh -c "cd ../var/www/html/app/scripts && php migrate.php"

.PHONY: init