<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "CON_EMPRESA" => array(
        "not_empty" => "Empresa não pode ser vazio.",
        "min_length" => "Empresa deve ter pelo menos 3 caracteres.",
        "max_length" => "Empresa deve ter no máximo 250 caracteres."
    ),
    "CON_KEYWORDS" => array(
        "not_empty" => "Keywords não pode ser vazio.",
    ),
    "CON_DESCRIPTION" => array(
        "not_empty" => "Description não pode ser vazio.",
    ),
    "CON_GOOGLE_ANALYTICS" => array(
        "not_empty" => "Google Analytics não pode ser vazio.",
    ),
);
?>                
