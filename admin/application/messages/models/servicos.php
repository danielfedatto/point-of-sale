<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "SER_TITULO" => array(
        "not_empty" => "Título não pode ser vazio.",
        "min_length" => "Título deve ter pelo menos 3 caracteres.",
        "max_length" => "Título deve ter no máximo 250 caracteres."
    ),
    "SER_ORDEM" => array(
        "not_empty" => "Ordem não pode ser vazio.",
    ),
    "SER_TEXTO" => array(
        "not_empty" => "Texto não pode ser vazio.",
    ),
);
?>                
