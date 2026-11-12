<?php

// CAMINHO DO ARQUIVO JSON
$caminho = __DIR__ . "/chamados.json";


// 1. LER TODOS OS CHAMADOS
function listarChamados() {
    global $caminho;

    if (!file_exists($caminho)) {
        return [];
    }

    $json = file_get_contents($caminho);
    $chamados = json_decode($json, true);

    if (!is_array($chamados)) {
        return [];
    }

    return $chamados;
}


// 2. SALVAR OS CHAMADOS NO JSON
function salvarChamados($chamados) {
    global $caminho;

    $json = json_encode(
        $chamados,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    return file_put_contents($caminho, $json) !== false;
}


// 3. CADASTRAR UM NOVO CHAMADO
function cadastrarChamado($nome, $setor, $equipamento, $descricao, $prioridade) {

    if (trim($nome) == "" || trim($descricao) == "") {
        return false;
    }

    $chamados = listarChamados();

    $novoChamado = [
        "nome" => $nome,
        "setor" => $setor,
        "equipamento" => $equipamento,
        "descricao" => $descricao,
        "prioridade" => $prioridade,
        "status" => "Aberto"
    ];

    $chamados[] = $novoChamado;

    return salvarChamados($chamados);
}


// 4. ATUALIZAR STATUS DO CHAMADO
function atualizarChamado($posicao, $novoStatus) {

    $chamados = listarChamados();

    $statusPermitidos = [
        "Aberto",
        "Em andamento",
        "Resolvido"
    ];

    if (!isset($chamados[$posicao])) {
        return false;
    }

    if (!in_array($novoStatus, $statusPermitidos)) {
        return false;
    }

    $chamados[$posicao]["status"] = $novoStatus;

    return salvarChamados($chamados);
}


// 5. EXCLUIR UM CHAMADO
function excluirChamado($posicao) {

    $chamados = listarChamados();

    if (!isset($chamados[$posicao])) {
        return false;
    }

    unset($chamados[$posicao]);

    $chamados = array_values($chamados);

    return salvarChamados($chamados);
}


// 6. CONTAR TODOS OS CHAMADOS
function totalChamados() {

    $chamados = listarChamados();

    return count($chamados);
}


// 7. CONTAR CHAMADOS POR STATUS
function contarPorStatus($status) {

    $chamados = listarChamados();

    $contador = 0;

    foreach ($chamados as $chamado) {

        if ($chamado["status"] == $status) {
            $contador++;
        }

    }

    return $contador;
}