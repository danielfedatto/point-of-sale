<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "LOE_TITULO_1" => array(
        "not_empty" => "Título 1 não pode ser vazio.",
        "min_length" => "Título 1 deve ter pelo menos 3 caracteres.",
        "max_length" => "Título 1 deve ter no máximo 200 caracteres."
    ),
    "LOE_TITULO_2" => array(
        "not_empty" => "Título 2 não pode ser vazio.",
        "min_length" => "Título 2 deve ter pelo menos 3 caracteres.",
        "max_length" => "Título 2 deve ter no máximo 200 caracteres."
    ),
    "LOE_CIDADE" => array(
        "not_empty" => "Cidade não pode ser vazio.",
        "min_length" => "Cidade deve ter pelo menos 3 caracteres.",
        "max_length" => "Cidade deve ter no máximo 200 caracteres."
    ),
    "LOE_DESCRICAO" => array(
        "not_empty" => "Descrição não pode ser vazio.",
    ),
);
?>                
