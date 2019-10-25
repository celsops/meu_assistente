create table if not exists tbl_notas(
    col_titulo VARCHAR(50) not null,
    col_descricao VARCHAR(200),
    col_hora VARCHAR(100),
    col_data VARCHAR(100),
    col_usuario VARCHAR(50) not null,
    col_id bigint not null PRIMARY KEY auto_increment
);
CREATE TABLE if not exists tbl_cor(
    col_cod INTEGER not null PRIMARY KEY,
    col_nome VARCHAR(50) not null
);
CREATE TABLE if not exists tbl_dia_semana(
    col_cod bigint not null PRIMARY KEY,
    col_nome VARCHAR(20) not null
);
CREATE TABLE if not exists tbl_dia_semana_nota(
    col_id_nota bigint not null,
    col_id_dia bigint not null
);
CREATE TABLE if not exists tbl_usuario(
    col_email VARCHAR(50) not null PRIMARY KEY,
    col_senha VARCHAR(100) not null
);
CREATE TABLE if not exists tbl_cor_nota(
    col_id_nota bigint not null,
    col_cod_cor bigint not null
);
/* INSERÇÃO DE DADOS */
INSERT INTO tbl_cor(col_cod,col_nome) values (1,"amarelo");
INSERT INTO tbl_cor(col_cod,col_nome) values (2,"azul");
INSERT INTO tbl_cor(col_cod,col_nome) values (3,"veremelho");

/* INSERÇÃO DE DADOS */
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (1,"domingo");
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (2,"segunda");
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (3,"terca");
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (4,"quarta");
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (5,"quinta");
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (6,"sexta");
INSERT INTO tbl_dia_semana(col_cod,col_nome) values (7,"sabado");
