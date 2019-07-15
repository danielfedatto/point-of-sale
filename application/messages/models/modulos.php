<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    'MOD_NOME' => array(
        'not_empty' => 'Nome não pode ser vazio.',
        'min_length' => 'Nome deve ter pelo menos 3 caracteres.',
        'max_length' => 'Nome deve ter no máximo 64 caracteres.'
    ),
    'MOD_LINK' => array(
        'not_empty' => 'Link não pode ser vazio.',
        'min_length' => 'Link deve ter pelo menos 3 caracteres.',
        'max_length' => 'Link deve ter no máximo 64 caracteres.'
    ),
    'CAM_ID' => array(
        'not_empty' => 'Categoria de Módulo não pode ser vazia.',
        'exists' => "Essa Categoria de Módulo não existe."
    )
);
?>