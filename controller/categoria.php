<?php
require_once 'model/Categoria.php';
require_once 'view/Categoria.php';
// categoria categorias
# Removendo 'veiculo' da array $url;
array_shift($url);

function get($consulta){
    $categoria = new Categoria();
    $viewCategoria = new ViewCategoria();
    if(count($consulta) == 1 && $consulta[0] == ""){
        $categorias = $categoria->consultar();
        $viewCategoria->exibirCategorias($categorias);
    }
    elseif(count($consulta) == 1){
        $categoria = $categoria->consultarPorId($consulta[0]);
        $viewCategoria->exibirCategoria($categoria);
    }    
    elseif(count($consulta) == 2 && $consulta[0] == "tipo"){       
        $categorias = $categoria->consultar($consulta[1]);
        $viewCategoria->exibirCategorias($categoria);
    }
    else{
        $codigo_resposta = 404;
        $erro = [
            'result'=>false,
            'erro'  => 'Erro: 404 - Recurso não encontrado'
        ];
        require_once 'view/erro404.php';
    }   
} 

function post($dados_categoria){
    $categoria = new Categoria();
    $viewCategoria = new ViewCategoria();
    $categoria->tipo = $dados_categoria->tipo;
    $categoria->icone = $dados_categoria->icone; 
    $viewMontadora->exibirCategoria($categoria->cadastrar());
}

function delete($registro){
    $categoria = new Categoria();
    $viewCategoria = new ViewCategoria();
    $result = false;
    $erro = "";
    if($veiculo->excluir($registro)){
        $result = true;
    }
    else{
        $erro = $veiculo->getErro();
    }
    $viewVeiculo->deleteVeiculo($result, $erro);

}

function put($registro, $dados_veiculo){
    $categoria = new Categoria();
    $viewCategoria = new ViewCategoria();
    $veiculo->id = $registro;
    $categoria->tipo = $dados_categoria->tipo;
    $categoria->icone = $dados_categoria->icone;  
    $viewMontadora->exibirCategoria($categoria->alterar());
}

switch($method){    
    // case "GET":get(@$url[0],@$url[1]);
    case "GET":get($url);
    break;
    case "POST":post($dadosRecebidos);
    break;
    case "PUT":put(@$url[0],$dadosRecebidos);
    break;
    case "DELETE":delete(@$url[0]);
    break;
    default:{
        echo json_encode(["method"=>"ERRO"]);
    }
    break;
}