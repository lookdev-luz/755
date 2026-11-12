<?php

// IMPORTAR AS FUNÇÕES
require_once "helpdesk-func.php";

$mensagem = "";


// IDENTIFICAR SE UM FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $acao = $_POST["acao"] ?? "";

    // CADASTRAR
    if ($acao == "cadastrar") {

        $nome = $_POST["nome"] ?? "";
        $setor = $_POST["setor"] ?? "";
        $equipamento = $_POST["equipamento"] ?? "";
        $descricao = $_POST["descricao"] ?? "";
        $prioridade = $_POST["prioridade"] ?? "";

        $resultado = cadastrarChamado(
            $nome,
            $setor,
            $equipamento,
            $descricao,
            $prioridade
        );

        if ($resultado) {
            $mensagem = "Chamado cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar chamado!";
        }
    }


    // ATUALIZAR
    if ($acao == "atualizar") {

        $posicao = filter_var(
            $_POST["posicao"] ?? null,
            FILTER_VALIDATE_INT
        );

        $novoStatus = $_POST["status"] ?? "";

        if ($posicao !== false && $posicao !== null &&
            atualizarChamado($posicao, $novoStatus)) {
            $mensagem = "Status atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar chamado!";
        }
    }


    // EXCLUIR
    if ($acao == "excluir") {

        $posicao = filter_var(
            $_POST["posicao"] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($posicao !== false && $posicao !== null &&
            excluirChamado($posicao)) {
            $mensagem = "Chamado excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir chamado!";
        }
    }
}


// BUSCAR OS DADOS ATUALIZADOS
$chamados = listarChamados();

// VARIÁVEIS DO RELATÓRIO
$total = totalChamados();
$abertos = contarPorStatus("Aberto");
$andamento = contarPorStatus("Em andamento");
$resolvidos = contarPorStatus("Resolvido");

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Help Desk - Sistema de Chamados</title>
</head>

<body>

    <h1>Sistema de Chamados de TI</h1>

    <p>Controle de suporte técnico industrial</p>

    <hr>

    <?php if ($mensagem != ""): ?>
        <p>
            <strong>
                <?= htmlspecialchars($mensagem) ?>
            </strong>
        </p>
    <?php endif; ?>


    <h2>Abrir Novo Chamado</h2>

    <form method="POST">

        <input type="hidden" name="acao" value="cadastrar">

        <label>Nome do funcionário:</label>
        <br>
        <input type="text" name="nome" required>

        <br><br>

        <label>Setor:</label>
        <br>
        <select name="setor">
            <option value="Produção">Produção</option>
            <option value="Administrativo">Administrativo</option>
            <option value="Logística">Logística</option>
            <option value="Financeiro">Financeiro</option>
            <option value="TI">TI</option>
        </select>

        <br><br>

        <label>Equipamento afetado:</label>
        <br>
        <select name="equipamento">
            <option value="Computador">Computador</option>
            <option value="Impressora">Impressora</option>
            <option value="Rede">Rede</option>
            <option value="Sistema">Sistema</option>
            <option value="Outro">Outro</option>
        </select>

        <br><br>

        <label>Descrição do problema:</label>
        <br>
        <textarea name="descricao" required></textarea>

        <br><br>

        <label>Prioridade:</label>
        <br>
        <select name="prioridade">
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Alta">Alta</option>
        </select>

        <br><br>

        <button type="submit">Cadastrar Chamado</button>

    </form>

    <hr>


    <h2>Relatório de Atendimentos</h2>

    <p>Total de chamados: <?= $total ?></p>

    <p>Chamados abertos: <?= $abertos ?></p>

    <p>Chamados em andamento: <?= $andamento ?></p>

    <p>Chamados resolvidos: <?= $resolvidos ?></p>

    <hr>


    <h2>Lista de Chamados</h2>

    <?php if (count($chamados) == 0): ?>

        <p>Nenhum chamado cadastrado.</p>

    <?php else: ?>

        <?php foreach ($chamados as $posicao => $chamado): ?>

            <h3>Chamado #<?= $posicao + 1 ?></h3>

            <p>
                <strong>Funcionário:</strong>
                <?= htmlspecialchars($chamado["nome"]) ?>
            </p>

            <p>
                <strong>Setor:</strong>
                <?= htmlspecialchars($chamado["setor"]) ?>
            </p>

            <p>
                <strong>Equipamento:</strong>
                <?= htmlspecialchars($chamado["equipamento"]) ?>
            </p>

            <p>
                <strong>Problema:</strong>
                <?= htmlspecialchars($chamado["descricao"]) ?>
            </p>

            <p>
                <strong>Prioridade:</strong>
                <?= htmlspecialchars($chamado["prioridade"]) ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?= htmlspecialchars($chamado["status"]) ?>
            </p>


            <h4>Atualizar Status</h4>

            <form method="POST">

                <input type="hidden" name="acao" value="atualizar">

                <input
                    type="hidden"
                    name="posicao"
                    value="<?= $posicao ?>"
                >

                <select name="status">

                    <option value="Aberto"
                        <?= $chamado["status"] == "Aberto" ? "selected" : "" ?>>
                        Aberto
                    </option>

                    <option value="Em andamento"
                        <?= $chamado["status"] == "Em andamento" ? "selected" : "" ?>>
                        Em andamento
                    </option>

                    <option value="Resolvido"
                        <?= $chamado["status"] == "Resolvido" ? "selected" : "" ?>>
                        Resolvido
                    </option>

                </select>

                <button type="submit">Atualizar</button>

            </form>


            <h4>Excluir Chamado</h4>

            <form method="POST">

                <input type="hidden" name="acao" value="excluir">

                <input
                    type="hidden"
                    name="posicao"
                    value="<?= $posicao ?>"
                >

                <button type="submit">Excluir</button>

            </form>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>

</body>
</html>