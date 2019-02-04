build:
	sudo docker-compose build
down:
	sudo docker-compose down
up:
	sudo docker-compose up
clear:
	sudo rm -rf .docker/data/log/

	sudo rm -rf .docker/php/logs/php/*
	sudo rm -rf .docker/php/logs/runtime/*
	sudo rm -rf .docker/php/data/*

	sudo rm -rf .docker/mariadb/logs/*
	sudo rm -rf .docker/mariadb/data/*

	sudo rm -rf .docker/mongodb/logs/*
	sudo rm -rf .docker/mongodb/data/*

	sudo rm -rf .docker/minexcoin/data/*
	sudo rm -rf .docker/apiDoc/data/*
	sudo rm -rf .docker/nginx/logs/*


	sudo rm -rf app/vendor/
	sudo rm -rf app/storage/runtime/log
	sudo rm -rf app/storage/runtime/cache
dump:
	sudo docker-compose exec db mysql_dump -u test -p test > dump.sql

apidoc:
	sudo docker-compose run apidoc yarn apidoc

unit-tests:
	sudo docker-compose exec php vendor/bin/codecept run unit --coverage

functional-tests:
	sudo docker-compose exec php vendor/bin/codecept run functional

tests:
	sudo docker-compose exec php vendor/bin/codecept run

migrate:
	sudo docker-compose exec php php bin/yii migrate

test-migrate:
	sudo docker-compose exec php php tests/bin/yii migrate/up --interactive=0

models:
	sudo docker-compose exec php php bin/yii gii/model --tableName=* --interactive=0 --overwrite=1

rpc:
	sudo docker-compose exec php php bin/yii amqp-rpc-server/run

payout:
	sudo docker-compose exec php php bin/yii payout/run

create-migrate:
	sudo docker-compose exec php php bin/yii migrate/create $(n)

privkey:
	sudo docker-compose exec php /root/MinexCoin/minexcoin-cli --conf=/root/MinexcoinConfig.conf importprivkey $(key)

getinfo:
	sudo docker-compose exec php /root/MinexCoin/minexcoin-cli --conf=/root/MinexcoinConfig.conf getinfo