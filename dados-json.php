<?php

// Verifica se o formulário foi enviado usando o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];

    // Recebe as notas de Português
    $portugues_prova1 = $_POST["portugues_prova1"];
    $portugues_prova2 = $_POST["portugues_prova2"];
    $portugues_prova3 = $_POST["portugues_prova3"];

    // Recebe as notas de Matemática
    $matematica_prova1 = $_POST["matematica_prova1"];
    $matematica_prova2 = $_POST["matematica_prova2"];
    $matematica_prova3 = $_POST["matematica_prova3"];

    // Recebe as notas de História
    $historia_prova1 = $_POST["historia_prova1"];
    $historia_prova2 = $_POST["historia_prova2"];
    $historia_prova3 = $_POST["historia_prova3"];

    // ==========================================
    // ORGANIZA OS DADOS EM UM ARRAY
    // ==========================================
    $novoAluno = [
        "nome" => $nome,
        "idade" => $idade,

        "notas" => [
            "portugues" => [
                "prova1" => $portugues_prova1,
                "prova2" => $portugues_prova2,
                "prova3" => $portugues_prova3,
            ],

            "matematica" => [
                "prova1" => $matematica_prova1,
                "prova2" => $matematica_prova2,
                "prova3" => $matematica_prova3,
            ],

            "historia" => [
                "prova1" => $historia_prova1,
                "prova2" => $historia_prova2,
                "prova3" => $historia_prova3,
            ]

        ]

    ];

    // SERVE PARA LER/ABRIR ARQUVO JSON
    $conteudoJson = file_get_contents(__DIR__ . "/dados/intro.json");

    // SERVE PARA CONVERTER JSON PARA ARRAY PHP
    // O true SERVE PARA CONVERTER O JSON EM ARRAY ASSOCIATIVO PARA PHP LER
    $alunos = json_decode($conteudoJson, true);

    // ADICIONAR O NOVO ALUNO
    $alunos[] = $novoAluno;

    // CONVERTER O ARRAY PHP PARA JSON
    $jsonAtualizado = json_encode(
        $alunos,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    // SALVAR NO ARQUIVO JSON
    //file_put_contents(__DIR__ . "/dados/intro.json", $jsonAtualizado);
$caminho = __DIR__ . "/dados/intro.json";

echo "<pre>";

echo "CAMINHO DO ARQUIVO:\n";
var_dump($caminho);

echo "\nARQUIVO EXISTE?\n";
var_dump(file_exists($caminho));

echo "\nJSON GERADO:\n";
var_dump($jsonAtualizado);

echo "\nTENTANDO SALVAR...\n";

$resultado = file_put_contents($caminho, $jsonAtualizado);

var_dump($resultado);

echo "</pre>";
    }

// LEITURA DOS DADOS PARA EXIBIÇÃO

//Lê o arquivo JSON
$conteudoJson = file_get_contents(__DIR__ . "/dados/intro.json");

// Converte o JSON para ARRAY PHP
$alunos = json_decode($conteudoJson, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>CADASTRO DE NOTAS</h1>
    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br><br>
        <label>Idade:</label>
        <input type="number" name="idade" required>
        <h2>Português</h2>
        <label>Prova 1:</label>
        <input type="number" name="portugues_prova1" min="0" max="10" step="0.1" required>
        <br><br>
        <label>Prova 2:</label>
        <input type="number" name="portugues_prova2" min="0" max="10" step="0.1" required>
        <br><br>
        <label>Prova 3:</label>
        <input type="number" name="portugues_prova3" min="0" max="10" step="0.1" required>
        <h2>Matemática</h2>
        <label>Prova 1:</label>
        <input type="number" name="matematica_prova1" min="0" max="10" step="0.1" required>
        <br><br>
        <label>Prova 2:</label>
        <input type="number" name="matematica_prova2" min="0" max="10" step="0.1" required>
        <br><br>
        <label>Prova 3:</label>
        <input type="number" name="matematica_prova3" min="0" max="10" step="0.1" required>
        <h2>História</h2>
        <label>Prova 1:</label>
        <input type="number" name="historia_prova1" min="0" max="10" step="0.1" required>
        <br><br>
        <label>Prova 2:</label>
        <input type="number" name="historia_prova2" min="0" max="10" step="0.1" required>
        <br><br>
        <label>Prova 3:</label>
        <input type="number" name="historia_prova3" min="0" max="10" step="0.1" required>
        <br><br>
        <button type="submit">Enviar</button>
    </form>

    <h1>ALUNOS CADASTRADOS</h1>

    <?php foreach ($alunos as $aluno) { ?>
        <h2> <?= $aluno["nome"] ?> </h2>
        <p> Idade: <?= $aluno["idade"] ?> </p>

        <!-- PORTUGUES -->
        <h2>PORTUGUÊS</h2>
        <p>Prova 1: <?= $aluno["notas"]["portugues"]["prova1"] ?></p>
        <p>Prova 2: <?= $aluno["notas"]["portugues"]["prova2"] ?></p>
        <p>Prova 3: <?= $aluno["notas"]["portugues"]["prova3"] ?></p>

        <!-- MATEMÁTICA -->
        <h2>MATEMÁTICA</h2>
        <p>Prova 1: <?= $aluno["notas"]["matematica"]["prova1"] ?></p>
        <p>Prova 2: <?= $aluno["notas"]["matematica"]["prova2"] ?></p>
        <p>Prova 3: <?= $aluno["notas"]["matematica"]["prova3"] ?></p>

        <!-- HISTÓRIA -->
        <h2>HISTÓRIA</h2>
        <p>Prova 1: <?= $aluno["notas"]["historia"]["prova1"] ?></p>
        <p>Prova 2: <?= $aluno["notas"]["historia"]["prova2"] ?></p>
        <p>Prova 3: <?= $aluno["notas"]["historia"]["prova3"] ?></p>




    <?php } ?>
    










</body>
</html>