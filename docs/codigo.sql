CREATE DATABASE chamados;
USE chamados;

CREATE TABLE admm(
ID int auto_increment primary key,
Nome VARCHAR(60) NOT NULL,
Apelido VARCHAR(30)NOT NULL,
Email VARCHAR(100) NOT NULL,
Status VARCHAR(3) NOT NULL,
Login VARCHAR(50) NOT NULL,
Senha VARCHAR(50) NOT NULL,
Permissoes TEXT NOT NULL
);

CREATE TABLE clientes(
ID INT AUTO_INCREMENT PRIMARY KEY,
Nome VARCHAR(60) NOT NULL,
Endereco VARCHAR(100) NOT NULL,
Bairro VARCHAR(30) NOT NULL,
Cidade VARCHAR(30) NOT NULL,
UF VARCHAR(2) NOT NULL,
CEP VARCHAR(9) NOT NULL,
Tel VARCHAR(15) NOT NULL,
Cel VARCHAR(15) NOT NULL,
Email VARCHAR(100) NOT NULL,
EnviaEmail ENUM('0','1') NOT NULL,
Tipo ENUM('I','J','F') NOT NULL,
Razao VARCHAR(100) NOT NULL,
CNPJ VARCHAR(30) NOT NULL,
IE VARCHAR(30) NOT NULL,
Contrato ENUM('0','1') NOT NULL,
VContrato DECIMAL(10,2) NOT NULL,
QNTHoras TIME NULL,
VHora DECIMAL(10,2) NOT NULL,
Desconto INT(4) NOT NULL,
Obs TEXT,
Situacao VARCHAR(2) NOT NULL,
Assinatura ENUM('0','1') NOT NULL
);


CREATE TABLE logincliente(
ID INT AUTO_INCREMENT PRIMARY KEY,
Nome VARCHAR(60) NOT NULL,
Endereco VARCHAR(100) NOT NULL,
Bairro VARCHAR(30) NOT NULL,
Cidade VARCHAR(30) NOT NULL,
UF VARCHAR(2) NOT NULL,
CEP VARCHAR(9) NOT NULL,
Tel VARCHAR(15) NOT NULL,
Cel VARCHAR(15) NOT NULL,
Email VARCHAR(100) NOT NULL,
Login VARCHAR(50) NOT NULL,
Senha VARCHAR(50) NOT NULL,
Clientes TEXT NOT NULL
);

CREATE TABLE material(
ID INT AUTO_INCREMENT PRIMARY KEY,
Material VARCHAR(200) NOT NULL,
Valor DECIMAL(10,2) NOT NULL,
Status VARCHAR(2) NOT NULL
);

CREATE TABLE equipamento(
ID INT AUTO_INCREMENT PRIMARY KEY,
Equipamento VARCHAR(200) NOT NULL,
IdCl INT(11) NOT NULL,
Descricao TEXT NOT NULL,
Status VARCHAR(2) NOT NULL
);

CREATE TABLE chamado(
ID INT AUTO_INCREMENT PRIMARY KEY,
IdCl INT(11) NOT NULL,
IDEquipamento INT(11) NOT NULL,
Contato1 VARCHAR(50) NOT NULL,
Contato2 VARCHAR(50) NOT NULL,
Descricao TEXT NOT NULL,
Data DATETIME NOT NULL,
Status VARCHAR(2) NOT NULL,
IDTecnico INT(11) NOT NULL,
DescricaoOS TEXT NULL,
TipoCob VARCHAR(3) NULL,
TempoOS TIME NULL,
ValorCob DECIMAL(10,2) NULL,
TipoOS VARCHAR(2) NULL,
StatusOS VARCHAR(2) NULL,
Confirmada VARCHAR(2) NULL,
TempoEspera DATETIME NULL,
TempoAtendimento DATETIME NULL,
DataOS DATETIME NULL
);

CREATE TABLE statuschamados(
ID INT AUTO_INCREMENT PRIMARY KEY,
Descricao VARCHAR(20) NOT NULL,
Status ENUM('0','1') NOT NULL
);

CREATE TABLE materiaischamados(
ID INT AUTO_INCREMENT PRIMARY KEY,
Descricao VARCHAR(200) NOT NULL,
QNT INT(11) NOT NULL,
Valor DECIMAL(10,2) NOT NULL,
VTotal DECIMAL(10,2) NOT NULL,
IDChamado INT(11) NOT NULL
);

CREATE TABLE comentariochamado(
ID INT AUTO_INCREMENT PRIMARY KEY,
Autor INT(11) NOT NULL,
Data DATETIME NOT NULL,
Comentario TEXT NOT NULL,
IdCh INT(11) NOT NULL
);


CREATE TABLE configuracoes(
ID INT AUTO_INCREMENT PRIMARY KEY,
NomeFantasia VARCHAR(100) NOT NULL,
End VARCHAR(200) NOT NULL,
Tel1 VARCHAR(15) NOT NULL,
Tel2 VARCHAR(15) NOT NULL,
Email VARCHAR(60) NOT NULL,
MSGPainel TEXT NULL,
OSOnLine INT(3) NOT NULL,
ObsOS TEXT NULL,
TempoMinOnLine TIME NULL,
TempoMinOffLine TIME NULL,
Checks TEXT NULL
);

INSERT INTO configuracoes (OSOnLine) VALUES ('100');