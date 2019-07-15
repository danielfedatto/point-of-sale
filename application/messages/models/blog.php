<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "CAB_ID" => array(
        "not_empty" => "Categorias Blog não pode ser vazio.",
        "existsCab" => "Esse Categorias Blog não existe."
    ),
    "BLO_DATA" => array(
        "not_empty" => "Data não pode ser vazio.",
    ),
    "BLO_TITULO" => array(
        "not_empty" => "Título não pode ser vazio.",
        "min_length" => "Título deve ter pelo menos 3 caracteres.",
        "max_length" => "Título deve ter no máximo 250 caracteres."
    ),
    "BLO_TEXTO" => array(
        "not_empty" => "Texto não pode ser vazio.",
    ),
);
?>                
