<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(
    'USU_NOME' => array(
        'not_empty' => 'Nome não pode ser vazio.',
        'min_length' => 'Nome deve ter pelo menos 3 caracteres.',
        'max_length' => 'Nome deve ter no máximo 100 caracteres.'
    ),
    'USU_EMAIL' => array(
        'not_empty' => 'E-mail não pode ser vazio.',
        'min_length' => 'E-mail deve ter pelo menos 3 caracteres.',
        'max_length' => 'E-mail deve ter no máximo 200 caracteres.'
    ),
    'USU_LOGIN' => array(
        'not_empty' => 'Login não pode ser vazio.',
        'min_length' => 'Login deve ter pelo menos 3 caracteres.',
        'max_length' => 'Login deve ter no máximo 50 caracteres.'
    ),
    'USU_DATA_CADASTRO' => array(
        'not_empty' => 'Data de Cadastro não pode ser vazia.'
    ),
    'PER_ID' => array(
        'not_empty' => 'Permissão não pode ser vazia.',
        'exists' => "Essa permissão não existe."
    )
);
?>