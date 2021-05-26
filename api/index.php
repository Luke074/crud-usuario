<?php
//import do arquivo para iniciar
//as dependencias da API
require_once("vendor/autoload.php");

//instancia da class App
$app = new \Slim\App();

//EndPoint para o Acesso a Raiz da Pasta da API
$app ->get('/', function($request, $response, $args){
    return $response->getBody()->write('API de Contatos do CRUD');
});
//EndPoint para o Acesso a todos os dados de contatos da API
$app ->get('/contatos', function($request, $response, $args){
    //import do arquivo que vai buscar no BD
    require_once('../bd/apiContatos.php');

    if(isset($request -> getQueryParams()['nome'])){

        //Aqui colocamos a variavel que ser enviada na reqisição
        $nome = $request-> getQueryParams()['nome'];

        $listContatos = buscarContatos($nome);

    }else{
        $listContatos = listarContatos(0);
    }

    
    //Valida se houve retorno de dados do banco
    if($listContatos)
        return $response    ->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write($listContatos);
    else
        return $response    ->withStatus(204);
});
//EndPoint para Buscar pelo id
$app ->get('/contatos/{id}', function($request, $response, $args){
    $id= $args['id'];
  
    require_once('../bd/apiContatos.php');

    $listContatos = listarContatos($id);

    if($listContatos)
        return $response    ->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write($listContatos);
    else
        return $response    ->withStatus(404);
    
});
//EndPoint para receber os dados via post
$app ->post('/contatos', function($request, $response, $args){
    //Recebe o contantType da requisição
    $contentType = $request->getHeaderLine('Content-Type');

    //Valida o tipo de Content-Type que esta chegando
    if($contentType == 'application/json'){
        //Recebe todos os dados enviados para a API no formato JSON
        $dadosJSON = $request->getParsedBody();
        
        //Valida se os dados que estao chegando são nulos

        //|| count(json_decode($dadosJSON, true)) == 0
        if($dadosJSON == "" || $dadosJSON == null){

            return $response    ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{
                                        "status": "Fail",
                                        "mensagem": "Os dados enviados não podem ser nulos"
                                        }
                                        ');

        }
        else{
            require_once('../bd/apiContatos.php');

            //Valida se os dados foram inseridos corretamente no BD
            $retornoDados = inserirContato($dadosJSON);
            if($retornoDados)
                return $response    ->withStatus(201)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write($retornoDados);
            else
                return $response    ->withStatus(400)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('
                                            {
                                                "status": "Fail",
                                                "mensagem": "Falha ao Inserir os dados no Banco.
                                                            Verifique os dados enviados estão corretos!"
                                            }
                                            ');
        }

    }else{
        //Retorna Erro Content-Type
        return $response    ->withStatus(400)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{
                                    "status": "Fail",
                                    "mensagem": "Erro no Content-Type da Requisição"
                                    }'
                                    );
    }
});
//EndPoint para Atualizar a foto via POST (Para receber elementos de file, somente poderá ser enviado via POST, mesmo que seja para fazer um update)
$app ->post('/contatos/{id}', function($request, $response, $args){

    //Recebe o contantType da requisição
    $contentType = $request->getHeaderLine('Content-Type');

    if(strstr($contentType, "multipart/form-data")){
        $id = $args['id'];
        $arquivo = $_FILES['file'];

        require_once('../bd/apiContatos.php');

        //Chama a função para fazer o upload e o update no banco
        $retornoDados = atualizarFoto($arquivo, $id);

        if($retornoDados == "1"){
            return $response    ->withStatus(201);
        }
        else if($retornoDados == "0"){
            return $response    ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('
                                        {
                                            "status": "Fail",
                                            "mensagem": "Não foi possível realizar o Update!!"
                                        }
                                        ');
        }
        else{
            return $response    ->withStatus(415)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('
                                        {
                                            "status": "Fail",
                                            "mensagem": "'.$retornoDados.'"
                                        }
                                        ');
        }

    }
});
$app ->delete('/contatos/delete/{id}', function($request, $response, $args){
    
    $id = $args['id'];
    require_once('../bd/apiContatos.php');

    $excluir = excluirContato($id);

    if($excluir)
        return $response    ->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write($excluir);
    else
        return $response    ->withStatus(400);
    
});
//Carrega todos os EndPoints criados na API
$app->run();
