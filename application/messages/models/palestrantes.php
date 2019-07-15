<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "PAL_DIA" => array(
        "not_empty" => "Dia não pode ser vazio.",
        "min_length" => "Dia deve ter pelo menos 3 caracteres.",
        "max_length" => "Dia deve ter no máximo 100 caracteres."
    ),
    "PAL_HORA" => array(
        "not_empty" => "Hora não pode ser vazio.",
        "min_length" => "Hora deve ter pelo menos 3 caracteres.",
        "max_length" => "Hora deve ter no máximo 100 caracteres."
    ),
    "PAL_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 100 caracteres."
    ),
    "PAL_SOBRENOME" => array(
        "not_empty" => "Sobrenome não pode ser vazio.",
        "min_length" => "Sobrenome deve ter pelo menos 3 caracteres.",
        "max_length" => "Sobrenome deve ter no máximo 100 caracteres."
    ),
    "PAL_INTRODUCAO" => array(
        "not_empty" => "Introdução não pode ser vazio.",
    ),
    "PAL_DESCRICAO" => array(
        "not_empty" => "Descrição não pode ser vazio.",
    ),
    "PAL_LADO_TEXTO" => array(
        "not_empty" => "Lado Texto não pode ser vazio.",
        "valorED" => "Lado Texto: Valor inválido."
    ),
);
?>                
