CREATE DATABASE FormAuto;
USE FormAuto;

CREATE TABLE Proprietario(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE Mensagens(
    id INT NOT NULL AUTO_INCREMENT,
    email_prop VARCHAR(255) NOT NULL,
    email_dstny VARCHAR(255) NOT NULL,
    nome_dstny VARCHAR(255) NOT NULL,
    msg_dstny VARCHAR(255) NOT NULL
);

ALTER TABLE Proprietario ADD PRIMAREY KEY (id);

ALTER TABLE Mensagem ADD PRIMAREY KEY (id), ADD KEY email_prop (Proprietario)

ALTER TABLE Mensagem ADD CONSTRAINT FOREIGN KEY (email_prop) REFERENCES Proprietario (email)