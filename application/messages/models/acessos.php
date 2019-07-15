<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    'ACE_IP' => array(
        'not_empty' => 'IP não pode ser vazio.',
        'min_length' => 'IP deve ter pelo menos 3 caracteres.',
        'max_length' => 'IP deve ter no máximo 20 caracteres.'
    ),
    'ACE_DATA' => array(
        'not_empty' => 'Data não pode ser vazia.'
    ),
    'ACE_HORA' => array(
        'not_empty' => 'Hora não pode ser vazia.'
    ),
    'ACE_MODULO' => array(
        'not_empty' => 'Módulo não pode ser vazio.',
        'min_length' => 'Módulo deve ter pelo menos 3 caracteres.',
        'max_length' => 'Módulo deve ter no máximo 50 caracteres.'
    ),
    'USU_ID' => array(
        'not_empty' => 'Usuário não pode ser vazio.',
        'exists' => "Esse usuário não existe."
    )
);
?>