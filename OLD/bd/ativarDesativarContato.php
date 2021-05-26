<?php

//validação para tratar o acesso do arquivo direto pela URL
if(isset($_GET['modo']))
{
    //Validação para tratar se a requisição é realmente para Alterar o Statos do registro
    if(strtoupper($_GET['modo']) == 'STATUS')
    {
        //Validação para tratar se foi informado um ID para Alteração
        if(isset($_GET['id']) && $_GET['id'] != "")
        {
            
         //###################### INICIO DA ALTERAÇÃO DO STTATUS DO REGISTRO #####################################  
            
            //Import do arquivo de Variaveis e Constantes
            require_once('../modulo/config.php');

            //Import do arquivo de função para conectar no BD
            require_once('conexaoMysql.php');

            //chama a função que vai estabelecer a conexão com o BD
            if(!$conex = conexaoMysql())
            {
                echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
                //die; //Finaliza a interpretação da página
            }
            
            //Recebendo o id para a alteração
            $idContato = $_GET['id'];
            
            //Realiza a inversão do valor para mudar no BD
            if($_GET['status']==0)
                $statusContato = 1;
            else
                $statusContato = 0;
            

            $sql = "update tblcontatos set statusContato='".$statusContato."'
                    where idContato = ".$idContato;

            //Executa no BD o Script SQL

            if (mysqli_query($conex, $sql))
            {
                echo("
                        <script>
                            alert('Status atualizado com sucesso!');
                            location.href = '../index.php';
                        </script>
                ");

                //Permite redirecionar para uma outra página
                //header('location:../index.php');
            }
            else
                echo("
                        <script>
                            alert('Erro ao atualizar o Status no Banco de Dados!');

                            window.history.back();
                        </script>

                    ");
            
            //###################### FIM DA EXCLUSÃO DO REGISTRO #####################################
            
        }else //Condição para tratar se foi informado um ID válido para excluir o registro
            echo("
            <script>
                alert('Nenhum registro foi informado para realizar a exclusão');
                location.href = '../index.php';
            </script>
    
        ");
        
    }else //Condição para tratar a variavel modo se é igual a EXCLUIR
        echo("
            <script>
                alert('Requisição inválida para excluir um registro!');
                location.href = '../index.php';
            </script>
    
        ");
    
}else //Condição para tratar o acesso do arquivo
    echo("
            <script>
                alert('Acesso inválido para esse arquivo!');
                location.href = '../index.php';
            </script>
    
        ");

?>