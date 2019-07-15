<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "MAR_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 250 caracteres."
    ),
    "MAR_TELEFONE_1" => array(
        "not_empty" => "Telefone 1 não pode ser vazio.",
        "min_length" => "Telefone 1 deve ter pelo menos 3 caracteres.",
        "max_length" => "Telefone 1 deve ter no máximo 250 caracteres."
    ),
);
?>                