<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "CAS_ID" => array(
        "not_empty" => "Cases não pode ser vazio.",
        "existsCas" => "Esse Cases não existe."
    ),
    "SER_ID" => array(
        "not_empty" => "Servicos não pode ser vazio.",
        "existsSer" => "Esse Servicos não existe."
    ),
);
?>                
