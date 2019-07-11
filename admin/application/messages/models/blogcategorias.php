<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "BLO_ID" => array(
        "not_empty" => "Blog não pode ser vazio.",
        "existsBlo" => "Esse Blog não existe."
    ),
    "CAT_ID" => array(
        "not_empty" => "Categorias não pode ser vazio.",
        "existsCat" => "Esse Categorias não existe."
    ),
);
?>                
