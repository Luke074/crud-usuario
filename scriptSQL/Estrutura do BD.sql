#Comentário
/*Comentário*/
#Criação do DataBase Contatos
create database dbcontatos20202t;

#Permite visualizar todos os databases criados
show databases;

#Ativa qual o database será utilizado
use dbcontatos20202t;
select * from tblestados;
select tblcontatos.*, tblestados.sigla
                from tblcontatos, tblestados
                where tblcontatos.idEstado = tblestados.idEstado and tblcontatos.statusContato = 1
                and tblcontatos.nome like 'Lucas';

#Cria a tabela de Estados
create table tblestados(
	idEstado int(8) not null auto_increment primary key,
    nome varchar(50) not null,
    sigla varchar(2) not null
);
insert into tblestados(nome, sigla)
values ('São Paulo', 'SP'),('Acre', 'Ac'),('Rio de Janeiro', 'RJ');


#Visualiza todas as tabelas existentes no database
show tables;

#Mostra os detalhes da tabela
desc tblestados;
select * from tblestados;

create table tblcontatos (
	idContato int not null auto_increment primary key,
    nome varchar(80) not null,
    foto varchar(40) not null,
	celular varchar(15),
    email varchar(50),
    idEstado int(8) not null,
    dataNascimento date not null,
    sexo varchar(1) not null,
    obs text,
    statusContato boolean not null,
    constraint FK_Estados_Contato
    foreign key (idEstado)
    references tblEstados(idEstado)
);
drop table tblcontatos;
show tables;
select * from tblcontatos;

desc tblcontatos;

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password
BY 'bcd127';  

insert into tblcontatos ( nome, foto, celular, email, idEstado, dataNascimento, sexo, obs, statusContato ) 
values ( 'Lucas', '3fe4ab34220cc2067b01080b7f8e13d3.png', '(11)99999-5555', 'teste@teste.com', 1, '2000-03-19', 'M', 'asdasd', '0' )

select tblcontatos.*, tblestados.sigla
from tblcontatos, tblestados
where tblcontatos.idEstado = tblestados.idEstado
and tblcontatos.statusContato = 1 order by tblcontatos.nome;
                
select tblcontatos.idContato, tblcontatos.nome,                tblcontatos.celular, tblcontatos.email, tblestados.sigla,        tblcontatos.statusContato, tblcontatos.foto 
                           from tblcontatos, tblestados
                           where tblcontatos.idEstado = tblestados.idEstado 
                           order by tblcontatos.idContato desc
		

select * from tblestados;

select * from tblcontatos;

use dbcontatos20202t;

insert into tblcontatos ( nome, celular, email, idEstado, dataNascimento, sexo, obs ) values
 ( 'Maria da Silva', '(11)98747-4422', 'fdgdgdfg@teste.com', 1, '2000-05-01', 'F', 'sdfsdf' );
 
 
 #Error Code: 1054. Unknown column 'obs' in 'field list'
 
 select * from tblcontatos order by idContato desc;
 
 
 
 select * from tblcontatos;
 
 
 

select tblcontatos.*, tblestados.sigla
                from tblcontatos, tblestados
                where tblcontatos.idEstado = tblestados.idEstado
                and tblcontatos.statusContato = 1 order by tblcontatos.nome;

 