use scarmed;
CREATE TABLE USUARIO(
    CPF varchar(15),
    NOME varchar(50),
    EMAIL varchar(50) unique,
    SENHA varchar(50),
    NUMERO_INSCRICAO varchar(10),
    TIPO_INSCRICAO int,
    DATA_NASCIMENTO DATE,
    TELEFONE varchar(15) unique,
    CEP varchar(9),
    ATIVO boolean,
    MOMENTO_CADASTRO TIMESTAMP,
    primary key (CPF)
);

CREATE TABLE USUARIO_CONFIRMACAO(
    CODIGO BIGINT AUTO_INCREMENT,
    EMAIL VARCHAR(50),
    CONFIRMADO boolean,
    ID_CONFIRMACAO VARCHAR(40),
    primary key(CODIGO)
);

CREATE TABLE USUARIO_RECUPERACAO_SENHA(
    CODIGO BIGINT AUTO_INCREMENT,
    EMAIL VARCHAR(50) not null,
    CODIGO_RECUPERACAO BIGINT not null,
    CODIGO_VALIDO boolean,
    primary key (CODIGO)
);