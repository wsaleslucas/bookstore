# LIVRARIA #

# PRE-REQUISITOS
- Ambiente Linux
- Docker 
- Docker-compose

# INSTALAÇÃO
O peojeto utiliza o Docker e Docker-compose para construir o ambiente

#### **1 - Faça o clone do Projeto

#### **2 - Acesse o diretorio onnde foi clonadot**
```
$ docker-compose up -d
```
verifique se os containers estão rodando 
```
$ docker ps -a 
```

#### **3 - Instale as dependencias do projeto **

```
$ docker exec -it php bash
$ chown -R root:root .
$ cd bookstore
$ composer install
$ chmod -R 777 .
$ npm run build
```
** saia do container

#### **5 - Alterando hosts**

Edit o arquivo hosts  (```/etc/hosts```) and add this line:
```
172.17.0.1      bookstore.local
```

* pronto o Proejto ja esta configurado e pronto para ser acessado "http://bookstore.local/"

## Tests

Acesse o contaier
```
$ docker exec -it php bash
$ cd bookstore
$ composer install
```
depois execute
```
# bin/phpunit 
```

* OBS: o projeto quando instalado e construido ja carrega por default as configurações do banco que estão no arquivo: config/dump_mysql.sql
