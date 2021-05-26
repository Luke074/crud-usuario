<?php

    function listarContatos($id){
        //Import do arquivo de Variaveis e Constantes
        require_once('../modulo/config.php');

        //Import do arquivo de função para conectar no BD
        require_once('conexaoMysql.php');

        if(!$conex = conexaoMysql())
        {
            echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
        }


        $sql = "select tblcontatos.*, tblestados.sigla
                from tblcontatos, tblestados
                where tblcontatos.idEstado = tblestados.idEstado and tblcontatos.statusContato = 1";

            if($id > 0){
                $sql = $sql . " and tblcontatos.idContato=".$id;
            }

            $sql = $sql . " order by tblcontatos.nome asc";

        $select = mysqli_query($conex, $sql);

        while($rsContatos = mysqli_fetch_assoc($select)){
            
            $dados[] = array(
                "idContatos"        => $rsContatos['idContato'],
                "nome"              => $rsContatos['nome'],
                "celular"           => $rsContatos['celular'],
                "email"             => $rsContatos['email'],
                "idEstado"          => $rsContatos['idEstado'],
                "sigla"             => $rsContatos['sigla'],
                "dataNascimento"    => $rsContatos['dataNascimento'],
                "sexo"              => $rsContatos['sexo'],
                "obs"               => $rsContatos['obs'],
                "foto"              => $rsContatos['foto'],
                "statusContato"     => $rsContatos['statusContato']
            );
        }
        if(isset($dados))
            $listContantatosJSON = convertJSON($dados);
        else
            return false;

        //verifica se foi gerado um arquivo JSON
        if(isset($listContantatosJSON)){
            return $listContantatosJSON;
        }
        else{
            return false;
        }

    }
    function buscarContatos($nome){
        require_once('../modulo/config.php');

        //Import do arquivo de função para conectar no BD
        require_once('conexaoMysql.php');

        if(!$conex = conexaoMysql())
        {
            echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
        }

        $sql = "select tblcontatos.*, tblestados.sigla
                from tblcontatos, tblestados
                where tblcontatos.idEstado = tblestados.idEstado and tblcontatos.statusContato = 1
                and tblcontatos.nome like '%".$nome."%'";

        $select = mysqli_query($conex, $sql);

        while($rsContatos = mysqli_fetch_assoc($select)){
            $dados[] = array(
                "idContatos"        => $rsContatos['idContato'],
                "nome"              => $rsContatos['nome'],
                "celular"           => $rsContatos['celular'],
                "email"             => $rsContatos['email'],
                "idEstado"          => $rsContatos['idEstado'],
                "sigla"             => $rsContatos['sigla'],
                "dataNascimento"    => $rsContatos['dataNascimento'],
                "sexo"              => $rsContatos['sexo'],
                "obs"               => $rsContatos['obs'],
                "foto"              => $rsContatos['foto'],
                "statusContato"     => $rsContatos['statusContato']
            );
        }

        if(isset($dados))
            $listContantatosJSON = convertJSON($dados);
        else
            return false;

        //verifica se foi gerado um arquivo JSON
        if(isset($listContantatosJSON)){
            return $listContantatosJSON;
        }
        else{
            return false;
        }
    }
    function inserirContato($dadosContato){
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

        //Converte o formato JSON para um Array de dados
        // $dadosContato = convertArray($dados);

        /*Recebe todos os dados da API*/
        $nome = $dadosContato['nome'];
        $celular = $dadosContato['celular'];
        $email = $dadosContato['email'];
        $estado = $dadosContato['estado'];
        $dataNascimento = $dadosContato['dataNascimento'];

        $sexo = $dadosContato['sexo'];
        $obs = $dadosContato['obs'];

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
                        ". $estado .",
                        '". $dataNascimento ."',
                        '". $sexo ."', 
                        '". $obs ."', 
                        '". $foto ."',
                        '". $statusContato ."'
                    )
                ";


        // echo($sql);

        // Executa no BD o Script SQL

        if (mysqli_query($conex, $sql)){
            $dados = convertJSON($dadosContato);
            return $dados;
        }
        else{
            return false;
        }
            
    }
    function atualizarFoto($file, $id){

        //import da função de upload
        require_once('upload.php');

        //Recebe a função para fazer o upload do arquivo
        $foto = uploadFoto($file);

        if(is_numeric($foto)){

            if($foto == 2){
                return "Extensão Inválida!!";
            }
            elseif($foto == 3){
                return "Tamanho Inválido";
            }

        }else{
            require_once('../modulo/config.php');

            //Import do arquivo de função para conectar no BD
            require_once('conexaoMysql.php');

            //chama a função que vai estabelecer a conexão com o BD
            if(!$conex = conexaoMysql())
            {
                echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
                //die; //Finaliza a interpretação da página
            }

            $sql = "update tblcontatos set foto = '".$foto."'
                    where idContato =".$id;

            if (mysqli_query($conex, $sql)){
                if(mysqli_affected_rows($conex)>0){
                    return true;
                }else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }
    function excluirContato($id){
        require_once('../modulo/config.php');

        //Import do arquivo de função para conectar no BD
        require_once('conexaoMysql.php');

        if(!$conex = conexaoMysql())
        {
            echo("<script> alert('".ERRO_CONEX_BD_MYSQL."'); </script>");
        }


        $sql = "delete from tblcontatos 
        where idContato = " . $id;

        // echo($sql);
        // die;

        // $nomeFoto = $_GET['foto'];
                
        //         //Validação para não apagar o arquivo padrão semFoto.png
        //         if($nomeFoto != "semFoto.png")
        //             //Apaga a foto da pasta arquivos
        //             unlink('../arquivos/'.$nomeFoto);
        
        if (mysqli_query($conex, $sql)){
            return true;
        }
        else{
            return false;
        }
    }
    //converte o array de dados em um JSON
    function convertJSON($objeto){
        //força o cabecalho do arquyivos a ser a aplicação do tipo JSON
        header("content-type:application/json");
        
        //converte o array de dados em JSON
        $listJSON = json_encode($objeto);

        return $listJSON;
    }
    //converte o JSON de dados em um array
    function convertArray($objeto){

        //converte o JSON de dados em Array
        $listJSON = json_dencode($objeto);

        return $listArray;
    }
    