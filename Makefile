include .env

install:
	@$(MAKE) -s down
	@$(MAKE) -s docker-build
	@$(MAKE) -s up
	@$(MAKE) -s composer-install
	@$(MAKE) -s spa-install
	@$(MAKE) -s migrate

up: docker-up
down: docker-down
ps:
	@docker-compose ps

docker-up:
	@docker-compose -p ${INDEX} up -d

docker-down:
	@docker-compose -p ${INDEX} down --remove-orphans

docker-build: \
	docker-build-app-php-cli \
	docker-build-app-php-fpm \
	docker-build-app-nginx

docker-build-app-nginx:
	@docker build --target=nginx \
	-t ${REGISTRY}/${INDEX}-nginx:${IMAGE_TAG} -f ./docker/Dockerfile .

docker-build-app-php-fpm:
	@docker build --target=fpm \
	-t ${REGISTRY}/${INDEX}-php-fpm:${IMAGE_TAG} -f ./docker/Dockerfile .

docker-build-app-php-cli:
	@docker build --target=cli \
	-t ${REGISTRY}/${INDEX}-php-cli:${IMAGE_TAG} -f ./docker/Dockerfile .

docker-logs:
	@docker-compose -p ${INDEX} logs -f

app-php-cli-exec:
	@docker-compose -p ${INDEX} run --rm php-cli $(cmd)

migrate:
	$(MAKE) app-php-cli-exec cmd="php ./yii migrate"

composer-install:
	$(MAKE) app-php-cli-exec cmd="composer install"

spa-install:
	@docker build --build-arg USER=$(whoami) --build-arg GROUP=$(whoami) \
	-t ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} -f ./docker/Dockerfile .
	@docker run --rm -v $(PWD)/frontend:/app ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} /bin/sh -c "yarn install"

spa-add:
	@docker run --rm -v $(PWD)/frontend:/app ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} /bin/sh -c "yarn add $(pkg)"

spa-remove:
	@docker run --rm -v $(PWD)/frontend:/app ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} /bin/sh -c "yarn remove $(pkg)"

spa-build:
	@rm -rf ./web/app-spa
	@docker run --rm -v $(PWD)/frontend:/app -v $(PWD)/web:/app-web \
		-e API_AUTH_KEY=${API_AUTH_KEY} \
		-e API_BASE_URL=http://localhost:${APP_WEB_PORT}${API_BASE_URL} \
 		${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} /bin/sh -c "yarn run build"

spa-dev:
	@rm -rf ./web/app-spa
	@docker run --rm -v $(PWD)/frontend:/app -v $(PWD)/web:/app-web \
		-e API_AUTH_KEY=${API_AUTH_KEY} \
		-e API_BASE_URL=http://localhost:${APP_WEB_PORT}${API_BASE_URL} \
 		${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} /bin/sh -c "yarn run dev"