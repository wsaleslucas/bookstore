set foreign_key_checks = 0;
CREATE DATABASE IF NOT EXISTS bookstore;

SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

USE bookstore;
CREATE TABLE `assunto` (
                           `cod_as` int(11) NOT NULL AUTO_INCREMENT,
                           `descricao` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
                           PRIMARY KEY (`cod_as`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `autor` (
                         `cod_au` int(11) NOT NULL AUTO_INCREMENT,
                         `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
                         PRIMARY KEY (`cod_au`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `livro` (
                         `cod` int(11) NOT NULL AUTO_INCREMENT,
                         `titulo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
                         `editora` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
                         `edicao` int(11) DEFAULT NULL,
                         `ano_publicacao` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
                         `preco` decimal(10,2) DEFAULT NULL,
                         PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `livro_assunto` (
                                 `id` int(11) NOT NULL AUTO_INCREMENT,
                                 `livro_cod` int(11) NOT NULL,
                                 `assunt_cod_as` int(11) NOT NULL,
                                 PRIMARY KEY (`id`),
                                 KEY `livro_assunto_livro_FK` (`livro_cod`),
                                 KEY `livro_assunto_assunto_FK` (`assunt_cod_as`),
                                 CONSTRAINT `livro_assunto_assunto_FK` FOREIGN KEY (`assunt_cod_as`) REFERENCES `assunto` (`cod_as`),
                                 CONSTRAINT `livro_assunto_livro_FK` FOREIGN KEY (`livro_cod`) REFERENCES `livro` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `livro_autor` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `autor_cod_au` int(11) NOT NULL,
                               `livro_cod` int(11) NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `livro_autor_livro_FK` (`livro_cod`),
                               KEY `livro_autor_autor_FK` (`autor_cod_au`),
                               CONSTRAINT `livro_autor_autor_FK` FOREIGN KEY (`autor_cod_au`) REFERENCES `autor` (`cod_au`),
                               CONSTRAINT `livro_autor_livro_FK` FOREIGN KEY (`livro_cod`) REFERENCES `livro` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `bookstore`.`vw_relatorio_livros` AS
select
    `l`.`cod` AS `cod`,
    `l`.`titulo` AS `titulo`,
    `l`.`editora` AS `editora`,
    `l`.`edicao` AS `edicao`,
    `l`.`ano_publicacao` AS `ano_publicacao`,
    `la`.`id` AS `id`,
    `la`.`autor_cod_au` AS `autor_cod_au`,
    `la`.`livro_cod` AS `livro_cod`,
    `a`.`cod_au` AS `cod_au`,
    `a`.`nome` AS `nome`,
    `a2`.`cod_as` AS `cod_as`,
    `a2`.`descricao` AS `descricao`
from
    ((((`bookstore`.`livro_autor` `la`
        join `bookstore`.`livro` `l` on
        ((`l`.`cod` = `la`.`livro_cod`)))
        join `bookstore`.`autor` `a` on
        ((`a`.`cod_au` = `la`.`autor_cod_au`)))
        join `bookstore`.`livro_assunto` `la2` on
        ((`la2`.`livro_cod` = `l`.`cod`)))
        join `bookstore`.`assunto` `a2` on
        ((`a2`.`cod_as` = `la2`.`assunt_cod_as`)))
group by
    `la`.`livro_cod`,
    `la`.`autor_cod_au`;