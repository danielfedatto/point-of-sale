<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    "NEW_EMAIL" => array(
        "not_empty" => "Email não pode ser vazio.",
        "min_length" => "Email deve ter pelo menos 3 caracteres.",
        "max_length" => "Email deve ter no máximo 250 caracteres."
    ),
);
?>                
