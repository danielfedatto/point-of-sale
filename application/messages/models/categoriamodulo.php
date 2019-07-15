<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "CAM_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 50 caracteres."
    ),
    "CAM_ORDEM" => array(
        "not_empty" => "Ordem não pode ser vazio.",
        "min_length" => "Ordem deve ter pelo menos 1 caracteres.",
        "max_length" => "Ordem deve ter no máximo 11 caracteres."
    ),
);
?>                
