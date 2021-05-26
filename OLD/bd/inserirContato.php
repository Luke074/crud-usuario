<?php 
/*Abre a conexão com o BD*/

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

/*Variaveis*/
$nome = (string) null;
$celular = (string) null;
$email = (string) null;
$estado = (int) null;
$dataNascimento = (string) null;
$sexo = (string) null;
$obs = (string) null;
$foto = (string) "semFoto.png";
$statusContato = (integer) 0;

/*Recebe todos os dados do formulário*/
$nome = $_POST['txtNome'];
$celular = $_POST['txtCelular'];
$email = $_POST['txtEmail'];
$estado = $_POST['sltEstados'];

//explode() - localiza um caracter separador do conteudo e dividi os dados em um vetor
$data = explode("/", $_POST['txtNascimento']);

//Arrumando a data para ficar no padrão americano
$dataNascimento = $data[2] . "-" . $data[1] . "-" . $data[0];


/*
Ex: explode()
26/08/2003
0  1   2

$data[0] = 26
$data[1] = 08
$data[2] = 2003


*/

$sexo = $_POST['rdoSexo'];
$obs = $_POST['txtObs'];

/* Recebendo o arquivo para Upload */
//Nome da pasta que iremos armazenas as imagens de upload

//Valida se o elemento file não esta vazio ou não foi enviado um elemento valido
if($_FILES['fleFoto']['size'] > 0 && $_FILES['fleFoto']['type']!="")
{
    //Nome da pasta para receber os arquivo
    $diretorioArquivos = "../arquivos/";
    
    //Reune todas as extensões permitidas para fazer o upload
    $arquivosPermitidos = array("image/jpeg","image/jpg","image/png");
    
    //Tamanho maximo do arquivo que será enviado para o servidor (corresponde a 5Mb que foi definido no php.ini)
    $tamanhoMaxArquivo = 5120;
    
    //Recebe todos os itens do arquivo a ser enviado para o servidor
    $arquivoUpload = $_FILES['fleFoto'];
    
    //caminho que o aruivo é colocado temporariamente antes de ser enviado para o servidor
    $caminhoTemp = $arquivoUpload['tmp_name'];
    
    //Recebe o tamnho do arquivo que será enviado para o servidor
        //Para converter o valor em Kb realizamos a divisão por 1024
    $tamanhoArquivo = round($arquivoUpload['size']/1024);
    
    //Recebe a extensão do arquivo que será enviado para o servidor
    $extensaoArquivo = $arquivoUpload['type'];
    
    //Valida se a extensão do arquivo é permitida para fazer o upload
    if(in_array($extensaoArquivo, $arquivosPermitidos))
    {
        //Valida se o tamanho do arquivo é permitido
        if($tamanhoArquivo <= $tamanhoMaxArquivo)
        {
            //Separando apenas o nome do arquivo da sua extensão, utilizando a função pathinfo()PATHINFO_FILENAME
            $nomeArquivo = pathinfo($arquivoUpload['name'], PATHINFO_FILENAME);
            
            //Separando apenas a extensão do nome do arquivo, utilizando a função pathinfo() PATHINFO_EXTENSION
            $ext = pathinfo($arquivoUpload['name'], PATHINFO_EXTENSION);
            
            //Gerando um novo nome parta o arquivo, utilizando os comandos (md5() para gerar uma hash de criptografia, concatenado com o uniqid() da maquina que é unica para cada hardware e juntando com o time() que a hora, minuto e segundo que esta esta sendo feito o upload)
            $nomeArquivoCripty = md5($nomeArquivo.uniqid(time()));
            
            
            $foto = $nomeArquivoCripty.".".$ext;

            /*
            Exemplos de algoritmos de criptografia de dados
            md5()
            sha1(),
            hash()
            */
            
            //move_uploaded_file() permite mover um arquivo entre dois diretórios
            if(move_uploaded_file($caminhoTemp, $diretorioArquivos.$foto))
                $statusUploadArquivo = true;
            else
                $foto = "semFoto.png";
                //$statusUploadArquivo = false;
                
                

       
        }
        else //Validação do tamanho do arquivo
        {
            echo("
            <script> 
                alert('Tamanho do arquivo maior do que ".$tamanhoMaxArquivo."Kb');
            </script>
            ");  
        }
    }
    
    else //Validação da extensão
    
    {
        echo("
            <script> 
                alert('Extensão de arquivo não permitida.');
            </script>
        ");
    }
    
    
    
    
    
}


$sql = "insert into tblcontatos 
            (
                nome, 
                celular, 
                email, 
                idEstado, 
                dataNascimento, 
                sexo, 
                obs,
                foto,
                statusContato
            )
            values
            (
                '". $nome ."',
                '". $celular ."',
                '". $email ."', 
                 ".$estado.",
                '". $dataNascimento ."',
                '". $sexo ."', 
                '". $obs ."', 
                '". $foto ."', 
                '". $statusContato ."' 
            )
        ";



//Executa no BD o Script SQL

if (mysqli_query($conex, $sql))
{
    echo("
            <script>
                alert('Registro Inserido com sucesso!');
                location.href = '../index.php';
            </script>
    ");
    
    //Permite redirecionar para uma outra página
    //header('location:../index.php');
}
else
    echo("
            <script>
                alert('Erro ao Inserir os dados no Banco de Dados! Favor verificar a digitação de todos os dados.');
                location.href = '../index.php';
                window.history.back();
            </script>
    
        ");

?>