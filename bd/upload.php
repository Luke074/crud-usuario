<?php 

//Função para realizar o Upload de arquivos (imagens) 
function uploadFoto($objFile)
{
    /* Recebendo o arquivo para Upload */
    //Nome da pasta que iremos armazenas as imagens de upload

    //Valida se o elemento file não esta vazio ou não foi enviado um elemento valido
    if($objFile['size'] > 0 && $objFile['type']!="")
    {
        //Nome da pasta para receber os arquivo
        $diretorioArquivos = "../arquivos/";

        //Reune todas as extensões permitidas para fazer o upload
        $arquivosPermitidos = array("image/jpeg","image/jpg","image/png");

        //Tamanho maximo do arquivo que será enviado para o servidor (corresponde a 5Mb que foi definido no php.ini)
        $tamanhoMaxArquivo = 5120;

        //Recebe todos os itens do arquivo a ser enviado para o servidor, que foi encaminhado como parametro na function
        $arquivoUpload = $objFile;

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
                    $statusUploadArquivo = false;

            }
            else //Validação do tamanho do arquivo
            {
                return 3;
                // echo("
                // <script> 
                //     alert('Tamanho do arquivo maior do que ".$tamanhoMaxArquivo."Kb');
                //     location.href = '../index.php';
                //     window.history.back();
                // </script>
                // ");  
            }
        }

        else //Validação da extensão

        {
            return 2;
            /*
            echo("
                <script> 
                    alert('Extensão de arquivo não permitida.');
                    location.href = '../index.php';
                    window.history.back();
                </script>
            ");
            */
        }

    }
    
    if ($statusUploadArquivo)
        return $foto;
    else
        return "semFoto.png";
}


?>