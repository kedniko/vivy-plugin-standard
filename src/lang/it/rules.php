<?php

use Kedniko\VivyPluginStandard\Enum\RulesEnum;

return [
    'default' => [
        'generic' => 'Validazione fallita',
        RulesEnum::ID_TYPE->value => 'Tipo errato',
        RulesEnum::ID_NOT_EMPTY->value => 'Questo campo non può essere vuoto',
        'riceived' => 'Ricevuto',
        RulesEnum::ID_MINLENGTH->value => 'Valore troppo corto',
        'valuesNotAllowed' => 'Valori non ammessi',
        'match' => 'I campi non corrispondono',
    ],

    'string' => [
        RulesEnum::ID_TYPE->value => 'Questa non è una stringa',
        RulesEnum::ID_NOT_EMPTY->value => 'Questa string non può essere vuota',
        RulesEnum::ID_MINLENGTH->value => 'Stringa troppo corta',
        RulesEnum::ID_MAXLENGTH->value => 'Stringa troppo lunga',
        RulesEnum::ID_LENGTH->value => 'Lunghezza stringa non permessa',
        'min-2-letters-per-word' => 'Minino 2 lettere per parola (solo lettere)',
    ],
    'array' => [
        RulesEnum::ID_TYPE->value => 'Questo non è un array',
        RulesEnum::ID_NOT_EMPTY->value => 'Questo campo non può essere vuoto',
    ],
    'bool' => [
        RulesEnum::ID_TYPE->value => 'Tipo errato',
    ],
    'number' => [
        RulesEnum::ID_BETWEEN->value => 'Numero fuori range',
        RulesEnum::ID_NOTBETWEEN->value => 'Numero fuori range',
        RulesEnum::ID_MIN->value => 'Numero troppo piccolo',
        RulesEnum::ID_MAX->value => 'Numero troppo grande',
    ],
    'float' => [
        RulesEnum::ID_TYPE->value => 'float: Tipo errato',
    ],
    'int' => [
        RulesEnum::ID_TYPE->value => 'int: Tipo errato',
    ],
    'intString' => [
        RulesEnum::ID_TYPE->value => 'La stringa deve contenere un valore intero',
    ],
    'intBool' => [
        RulesEnum::ID_TYPE->value => 'Si accettano solo i valori 0 e 1',
    ],
    'boolString' => [
        RulesEnum::ID_TYPE->value => 'La stringa deve essere o "true" o "false"',
    ],
    'date' => [
        RulesEnum::ID_TYPE->value => 'La data non è valida',
        RulesEnum::ID_MIN->value => 'Data troppo lontana',
        RulesEnum::ID_MAX->value => 'Data troppo recente',
        RulesEnum::ID_BETWEEN->value => 'Data non nell\'intervallo permesso',
        RulesEnum::ID_NOTBETWEEN->value => 'Data non nell\'intervallo permesso',
    ],
    'email' => [
        RulesEnum::ID_TYPE->value => 'Email non valida',
    ],
    'phone' => [
        RulesEnum::ID_TYPE->value => 'Telefono non valido',
        RulesEnum::ID_NOT_EMPTY->value => 'Il telefono non può essere vuoto',
    ],
];
