#Comentário
/*Comentário*/

#Criação do DataBase Contatos
create database dbcontatos20202t;

#Permite visualizar todos os databases criados
show databases;

#Ativa qual o database será utilizado
use dbcontatos20202t;

#Cria a tabela de Estados
create table tblestados(
	idEstado int(8) not null auto_increment primary key,
    nome varchar(50) not null,
    sigla varchar(2) not null
);

#Visualiza todas as tabelas existentes no database
show tables;

#Mostra os detalhes da tabela
desc tblestados;

create table tblcontatos (
	idContato int not null auto_increment primary key,
    nome varchar(80) not null,
	celular varchar(15),
    email varchar(50),
    idEstado int(8) not null,
    dataNascimento date not null,
    sexo varchar(1) not null,
    obs text,
    constraint FK_Estados_Contato
    foreign key (idEstado)
    references tblEstados(idEstado)
);

show tables;

desc tblcontatos;

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password
BY 'bcd127';  


insert into tblcontatos (nome, celular, email, idEstado, dataNascimento, sexo, obs)
values('José', 
'1199854-1040',
'jose@uol.com.br', 
1, 
'2000-07-10', 
'M', 
'teste' );

insert into tblestados(nome, sigla)
values ('Acre', 'AC');
		

select * from tblestados;

select * from tblcontatos;

use dbcontatos20202t;

insert into tblcontatos ( nome, celular, email, idEstado, dataNascimento, sexo, obs ) values
 ( 'Maria da Silva', '(11)98747-4422', 'fdgdgdfg@teste.com', 1, '2000-05-01', 'F', 'sdfsdf' );
 
 
 #Error Code: 1054. Unknown column 'obs' in 'field list'
 
 select * from tblcontatos order by idContato desc;
 
 
 
 select * from tblestados;
 
 
 















