<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "CON_DATA" => array(
        "not_empty" => "Data não pode ser vazio.",
    ),
    "CON_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 250 caracteres."
    ),
    "CON_EMAIL" => array(
        "not_empty" => "Email não pode ser vazio.",
        "min_length" => "Email deve ter pelo menos 3 caracteres.",
        "max_length" => "Email deve ter no máximo 250 caracteres."
    ),
    "CON_FONE" => array(
        "not_empty" => "Fone não pode ser vazio.",
        "min_length" => "Fone deve ter pelo menos 3 caracteres.",
        "max_length" => "Fone deve ter no máximo 50 caracteres."
    ),
    "CON_MENSAGEM" => array(
        "not_empty" => "Mensagem não pode ser vazio.",
    ),
);
?>                
