<?php 
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
    
    $id = $_POST['idContato'];

    $sql = "select tblcontatos.*, tblestados.sigla
            from tblcontatos, tblestados
            where tblestados.idEstado = tblcontatos.idEstado
            and tblcontatos.idContato = ".$id;

    $select = mysqli_query($conex, $sql);
    
    if ($rsContato = mysqli_fetch_assoc($select))
    {
        $nome = $rsContato['nome'];
        $celular = $rsContato['celular'];
        $email = $rsContato['email'];
        //Tratamento da data para converter no padrão brasileiro    
        $dataNascimento = explode("-", $rsContato['dataNascimento']); 
        $dataNasc = $dataNascimento[2]."/".$dataNascimento[1]."/".$dataNascimento[0];            
        $sexo = $rsContato['sexo'];

       //Validação para ativar o radio do sexo    
        if (strtoupper($sexo) == "F")
           $sexo = "Feminino";
        elseif(strtoupper($sexo) == "M") 
           $sexo = "Masculino";

        $obs = $rsContato['obs']; 
        $sigla = $rsContato['sigla']; 
 
    }

?>

<html>
    <head>
        <title>Visualizar Contato</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script>
            $(document).ready(function(){
                //fadeIn
                //toggle
                //slideDown
                //slideToggle
                $("#fecharModal").click(function(){
                    $("#modalContainer").fadeOut();
                });
            });
        
        </script>
    </head>
    <body>
        <div id="fecharModal">
            Fechar
        </div>
        <div id="visualizarContatos">
            <table id="visualizarContato">
                <tr>
                    <td>
                        Nome:
                    </td>
                    <td>
                        <?=$nome?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Celular:
                    </td>
                    <td>
                        <?=$celular?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Email:
                    </td>
                    <td>
                        <?=$email?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Estado:
                    </td>
                    <td>
                        <?=$sigla?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Data Nascimento
                    </td>
                    <td>
                        <?=$dataNasc?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Sexo:
                    </td>
                    <td>
                        <?=$sexo?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Obs:
                    </td>
                    <td>
                        <?=$obs?>
                    </td>
                </tr>

            </table>
        </div>
    
    </body>

</html>