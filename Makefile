.PHONY: *

help:
	@printf "\033[33mComo usar:\033[0m\n  make [comando] [arg=\"valor\"...]\n\n\033[33mComandos:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-30s\033[0m %s\n", $$1, $$2}'

down: ## Derrubando todos os containers do projeto
	docker-compose -f docker-compose.yaml down

up: ## Subindo todos os containers do projeto
	cp .env.example .env || true
	docker-compose -f docker-compose.yaml up -d

uplogs: ## Subindo os containers para acompanhar os LOGS via kibana
	sudo mkdir -p .data/elasticsearch || true
	sudo chown 1000 .data/elasticsearch || true
	docker network create base-laravel || true
	docker-compose -f docker-compose.kibana.yaml up -d

cache: ## Criando cache das rotas
	make clear
	docker-compose -f docker-compose.yaml exec app php artisan route:cache

clear: ## Limpando todos os caches
	docker-compose -f docker-compose.yaml exec app php artisan config:clear
	docker-compose -f docker-compose.yaml exec app php artisan cache:clear
	docker-compose -f docker-compose.yaml exec app php artisan view:clear
	docker-compose -f docker-compose.yaml exec app php artisan route:clear
	docker-compose -f docker-compose.yaml exec app chmod 777 -R storage bootstrap

migrate: ## Executando todas as migrações
	docker-compose -f docker-compose.yaml exec app php artisan migrate

migrate-fresh: ## Reexecutando todas as migrações
	docker-compose -f docker-compose.yaml exec app php artisan migrate:fresh

seed: ## Rodando as seeders
	docker-compose -f docker-compose.yaml exec app php artisan db:seed
	docker-compose -f docker-compose.yaml exec app php artisan module:seed

bash: ## Entrando dentro do bash
	docker-compose -f docker-compose.yaml exec app bash

cron: ## Entrando dentro do cron
	docker-compose -f docker-compose.yaml exec cron bash

test: ## Executando todos os testes
	docker-compose -f docker-compose.yaml exec app composer run test

chown: ## Colocando usuário atual para as pastas
	sudo chown -R ${USER}:${USER} app modules config tests database vendor resources public_html

version: ## Criando versão
	echo "`date`" > public_html/version.txt
