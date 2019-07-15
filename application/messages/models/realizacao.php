<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "REA_NOME" => array(
        "not_empty" => "Nome não pode ser vazio.",
        "min_length" => "Nome deve ter pelo menos 3 caracteres.",
        "max_length" => "Nome deve ter no máximo 200 caracteres."
    ),
    "REA_DESCRICAO" => array(
        "not_empty" => "Descrição não pode ser vazio.",
    ),
    "REA_TELEFONES" => array(
        "not_empty" => "Telefones não pode ser vazio.",
        "min_length" => "Telefones deve ter pelo menos 3 caracteres.",
        "max_length" => "Telefones deve ter no máximo 250 caracteres."
    ),
    "REA_EMAIL" => array(
        "not_empty" => "Email não pode ser vazio.",
        "min_length" => "Email deve ter pelo menos 3 caracteres.",
        "max_length" => "Email deve ter no máximo 250 caracteres."
    ),
    "REA_FACEBOOK" => array(
        "not_empty" => "Facebook não pode ser vazio.",
        "min_length" => "Facebook deve ter pelo menos 3 caracteres.",
        "max_length" => "Facebook deve ter no máximo 250 caracteres."
    ),
    "REA_INSTAGRAN" => array(
        "not_empty" => "Instagran não pode ser vazio.",
        "min_length" => "Instagran deve ter pelo menos 3 caracteres.",
        "max_length" => "Instagran deve ter no máximo 250 caracteres."
    ),
    "REA_ENDERECO" => array(
        "not_empty" => "Endereço não pode ser vazio.",
    ),
);
?>                
