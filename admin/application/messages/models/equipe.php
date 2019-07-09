<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "EQU_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 250 caracteres."
    ),
    "EQU_ORDEM" => array(
        "not_empty" => "Ordem não pode ser vazio.",
    ),
);
?>                
