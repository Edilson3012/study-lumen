create database avaliation;

use avaliation;

create table vendedor(
    id integer primary key auto_increment not null,
    nome_completo varchar(60),
    nome_abreviado varchar(30),
    dt_admissao date
);

CREATE TABLE cliente(
    id integer auto_increment primary key not null,
    cnpj varchar(18),
    nome varchar(60),
    dt_fundacao date
);

CREATE TABLE carteira(
    id integer auto_increment primary key not null,
    id_vendedor integer,
    id_cliente integer,
    FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id`),
    FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`)
);
