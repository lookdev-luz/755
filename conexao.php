<?php
// PHP: Linguagem que executa as regras do sistema.
// MySQL: SGBD
// PDO: Interface do PHP que permite conversar com o banco de dados por meio de um driver.

// host = '194.61.238.119'
$host = 'localhost';
$db = 'lucasluz';
$user = 'lucasluz';
$pass = '147258369Sofia!@#$%';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset",
        $user,
        $pass
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "Conectado com sucesso!";

} catch (PDOException $e) {
    echo "ERRO AO CONECTAR AO BANCO DE DADOS:\n";
    echo $e->getMessage();
}














?>