<?php
$ausente = false;

$tempoAtual = time();

// Faz uma condição entre o tempo do ultimo click e o tempo atual.
// Caso dê maior que 60 segundos, redireciona para a pagina desejada.
// Caso não de maior, apenas atualiza o valor do ultimo clique para o valor atual.

if ( ($tempoAtual - $_COOKIE["ultimoclique"]) > 300 ) { // 5 minutos

    $ausente = true;

}

echo json_encode(array("ausente" => $ausente));

?>