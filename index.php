<?php
$idEstado = 0;
//Variavel que será utilizada no atributo action do form (Cadastrar e Atualizar)
$action = "bd/inserirContato.php";

//Import do arquivo de Variaveis e Constantes
require_once('modulo/config.php');

//Import do arquivo de função para conectar no BD
require_once('bd/conexaoMysql.php');

//chama a função que vai estabelecer a conexão com o BD
if(!$conex = conexaoMysql())
{
    echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
    //die; //Finaliza a interpretação da página
}

//#####################CÓDIGO PARA CARREGAR OS DADOS NAS CAIXAS (EDITAR)
    //Validação para ver se existe a variavel modo
    if(isset($_GET['modo']))
    {
        //Validação para verificar se modo é para buscar no banco o registro
        if(strtoupper($_GET['modo']) == "CONSULTAR")
        {
            //Validação para saber se id foi encaminhado
            if(isset($_GET['id']) && $_GET['id'] != "") 
            {
                $id = $_GET['id'];
                
                //Ativa o recurso para utilização de variaveis de sessão.
                //Uma variavel de sessão permanece ativa até que o programa destrua ela ou o navegado seja fechado
                session_start();
                
                //Criamos uma variavel chamada id como sendo uma variavel de sessão
                $_SESSION['id'] = $id;
                
                $sql = "select tblcontatos.*, tblestados.sigla
                        from tblcontatos, tblestados
                        where tblestados.idEstado = tblcontatos.idEstado
                        and tblcontatos.idContato = ".$id;
                
                $select = mysqli_query($conex, $sql);
                
                if($rsContatos = mysqli_fetch_assoc($select))
                {
                   $nome = $rsContatos['nome']; 
                   $celular = $rsContatos['celular']; 
                   $email = $rsContatos['email']; 
                    
                   //Tratamento da data para converter no padrão brasileiro    
                   $dataNascimento = explode("-", $rsContatos['dataNascimento']); 
                   $dataNasc = $dataNascimento[2]."/".$dataNascimento[1]."/".$dataNascimento[0];            
                   $sexo = $rsContatos['sexo'];
                    
                   //Validação para ativar o radio do sexo    
                   if (strtoupper($sexo) == "F")
                       $chkFeminino = "checked";
                   elseif(strtoupper($sexo) == "M") 
                       $chkMasculino = "checked";
                       
                   $obs = $rsContatos['obs']; 
                    
                   $idEstado = $rsContatos['idEstado']; 
                   $sigla = $rsContatos['sigla']; 
                    
                   $action = "bd/atualizarContato.php";
         
                }
                
                
            }
        }
    }
//#######################EDITAR#####################################

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script src="js/jquery.js"></script>
        
        <script>
            $(document).ready(function(){
                
                //Function para carregar a Modal
                $(".pesquisar").click(function(){
                   $("#modalContainer").fadeIn(2000);
                });
                
                
                
            });
            
            //Function para carregar o visualizar Contato na modal
            function visualizarContato(id)
            {

                $.ajax({
                    type: "POST",
                    url: "visualizarContato.php",
                    data: {idContato:id},
                    success: function(dados){
                        $("#modal").html(dados);
                    }
                    
                }); 
                
            }
        
        </script>

    </head>
    <body>
        <div id="modalContainer">
            <div id="modal">
                
            </div>
        </div>
        
        <!-- 
            Elementos para formulário do HTML 5
                <input type="tel" - indica que o dado a ser digitado será um telefone
                <input type="email" - indica que o dado a ser digitado será email
                <input type="url" - indica que o dado a ser digitado será o endereço de um site
                <input type="number" - indica que o dado será selecionado pelo usuário
                <input type="range" - criar uma régua de numeros a serem selecionados
                <input type="color" - permite que o usuário selecione uma cor e ele retorna o hexadecimal da cor escolhida

                Obs: cuidado, pois esses 3 elementos não funcionam em todos os navegadores
                    <input type="date" - permite que o usuário utilize um calendário na escolha da data
                    <input type="month" - permite que o usuário utilize um calendário na escolha apenas do mês
                    <input type="week" - permite que o usuário utilize um calendário na escolha apenas da semana

                placeholder - permite colocar uma mensagem de dica dentro da caixa
                required - deixa a caixa sendo obrigatória na digitação
                pattern - 

        -->
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
            </div>
            <div id="cadastroInformacoes">
                <!-- Para enviar arquivos pelo input type = "file", é obrigatório a utilização do atributo enctype="multipart/form-data" 

                Também é obrigatório o method do forma ser POST, não é possivel recuperar o arquivo utilizando outro metodo
                -->
                <form action="<?=$action?>" name="frmCadastro" method="post" enctype="multipart/form-data">
                   
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Nome: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?=@$nome?>" placeholder="Digite seu Nome" required pattern="[a-z A-Z é]*">
                        </div>
                    </div>
                     <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Escolha um arquivo: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="file" name="fleFoto" accept=".png, .jpg">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Celular: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?=@$celular?>" pattern="[(][0-9]{2}[)][0-9]{5}-[0-9]{4}" placeholder="(99)99999-9999">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Email: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?=@$email?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Estados: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <select name="sltEstados">
                                <?php 
                                    if(isset($_GET['modo']) && strtoupper($_GET['modo'])=="CONSULTAR")
                                        {
                                ?>
                                        <option value="<?=$idEstado?>"><?=$sigla?></option>
                                <?php 
                                        }
                                     else
                                       { 
                                 ?>
                                        <option value="">Selecione um Item</option>
       
                                <?php
                                       }
                                        
                                    $sql = "select * from tblestados
                                            where idEstado <>".$idEstado ;
                                   
                                    $select = mysqli_query($conex, $sql);
                                    
                                    /*
                                        RS - RecordSet
                                        RS - Resultado
                                    
                                    */
                                
                                    while($rsEstados = mysqli_fetch_assoc($select))
                                    {
                                ?>
                                
                                    <option value="<?=$rsEstados['idEstado']?>"> <?=$rsEstados['sigla'];?> </option>
                                
                                <?php 
                                    }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Data de Nascimento: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNascimento" value="<?=@$dataNasc?>" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                           Sexo:
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="radio" name="rdoSexo" value="F" <?=@$chkFeminino?>>Feminino.
                            <input type="radio" name="rdoSexo" value="M" <?=@$chkMasculino?> >Masculino.
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <p> Observações: </p>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50" rows="7"><?=@$obs?></textarea>
                        </div>
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas"> Nome </td>
                    <td class="tblColunas"> Celular </td>
                    <td class="tblColunas"> Estado </td>
                    <td class="tblColunas"> Email </td>
                    <td class="tblColunas"> Foto </td>
                    <td class="tblColunas"> Opções </td>
                </tr>
                
                <?php
                    //Script para buscar todos os dados no BD
                    $sql = "select tblcontatos.idContato, tblcontatos.nome, tblcontatos.celular, tblcontatos.email, tblestados.sigla,        tblcontatos.statusContato, tblcontatos.foto 
                           from tblcontatos, tblestados
                           where tblcontatos.idEstado = tblestados.idEstado 
                           order by tblcontatos.idContato desc
                        ";
                    
                    //Executa o script no BD (Retorna o conteudo existente
                    // no banco de dados e armazena na variavel $select)
                    $select = mysqli_query($conex, $sql);
                    
                    /*
                        mysqli_fetch - permite converter uma estrutura que veio do BD para um formato de lista, temos 3 tipos de fetch
                        
                        mysqli_fetch_array - cria uma lista de dados, porém é um código mais obsoleto
                        
                        mysqli_fetch_assoc - cria uma lista de dados, com mais velocidade e segurança no processo de conversão
                        
                        mysqli_fetch_object - cria uma lista de dados em um formato de objeto
                    
                    */
                    //Permite gerenciar a qtde de vezes que a repetição irá realizar, além de converter os dados do BD em uma lista utilizando o mysqli_fetch_assoc
                    while($rsContatos = mysqli_fetch_assoc($select))
                    {
                ?>
                    <tr id="tblLinhas">
                        <td class="tblColunas"><?=$rsContatos['nome']?>  </td>
                        <td class="tblColunas"><?=$rsContatos['celular']?>  </td>
                        <td class="tblColunas"><?=$rsContatos['sigla']?>  </td>
                        <td class="tblColunas"><?=$rsContatos['email']?>  </td>
                        <td class="tblColunas"><img src="arquivos/<?=$rsContatos['foto']?>" class="foto">  </td>
                        <td class="tblColunas">
                            <a href="bd/excluirContato.php?modo=excluir&id=<?=$rsContatos['idContato']?>&foto=<?=$rsContatos['foto']?>" onclick="return confirm('Deseja realmente excluir esse Registro?')">
                                <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">
                            </a>
                            
                       
                            <a href="index.php?modo=consultar&id=<?=$rsContatos['idContato']?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>
                            
                            <img src="img/search.png" alt="pesquisar" title="Pesquisar" class="pesquisar" onclick="visualizarContato(<?=$rsContatos['idContato']?>);">
                            
                            <a href="bd/ativarDesativarContato.php?modo=status&id=<?=$rsContatos['idContato']?>&status=<?=$rsContatos['statusContato']?>">
                                <img src="img/<?=$rsContatos['statusContato']?>.png" alt="Editar" title="Editar" class="editar">
                            </a>
                        
                        </td>
                    </tr>
                <?php 
                    }
                
                ?>    
                
            </table>

        </div>
    </body>
</html>