<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "LOI_ID" => array(
        "not_empty" => "Lote Ingressos não pode ser vazio.",
        "existsLoi" => "Esse Lote Ingressos não existe."
    ),
    "ING_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 200 caracteres."
    ),
    "ING_ORDEM" => array(
        "not_empty" => "Ordem não pode ser vazio.",
    ),
    "ING_LINK_COMPRA" => array(
        "not_empty" => "Link Compra não pode ser vazio.",
        "min_length" => "Link Compra deve ter pelo menos 3 caracteres.",
        "max_length" => "Link Compra deve ter no máximo 250 caracteres."
    ),
);
?>                
