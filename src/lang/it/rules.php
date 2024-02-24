<?php

use Kedniko\VivyPluginStandard\Enum\RulesEnum;

return [
    'default' => [
        'generic' => 'Validazione fallita',
        RulesEnum::ID_TYPE->value => 'Tipo errato',
        RulesEnum::ID_REQUIRED->value => 'Questo campo è obbligatorio',
        RulesEnum::ID_NOT_NULL->value => 'Questo campo non può essere null',
        RulesEnum::ID_NULL->value => 'Questo campo deve essere null',
        RulesEnum::ID_NOT_EMPTY->value => 'Questo campo non può essere vuoto',
        RulesEnum::ID_NOT_EMPTY_STRING->value => 'Questo campo non può essere una stringa vuota',
        'riceived' => 'Ricevuto',
        RulesEnum::ID_MINLENGTH->value => 'Valore troppo corto',
        'valuesNotAllowed' => 'Valori non ammessi',
        'match' => 'I campi non corrispondono',
    ],

    'string' => [
        RulesEnum::ID_TYPE->value => 'Questa non è una stringa',
        RulesEnum::ID_REQUIRED->value => 'Questa stringa è obbligatoria',
        RulesEnum::ID_NOT_NULL->value => 'Questa stringa non può essere null',
        RulesEnum::ID_NOT_EMPTY->value => 'Questa string non può essere vuota',
        RulesEnum::ID_NOT_EMPTY_STRING->value => 'Questa stringa non può essere vuota',
        RulesEnum::ID_MINLENGTH->value => 'Stringa troppo corta',
        RulesEnum::ID_MAXLENGTH->value => 'Stringa troppo lunga',
        RulesEnum::ID_LENGTH->value => 'Lunghezza stringa non permessa',
        'min-2-letters-per-word' => 'Minino 2 lettere per parola (solo lettere)',
    ],
    'array' => [
        RulesEnum::ID_TYPE->value => 'Questo non è un array',
        RulesEnum::ID_REQUIRED->value => 'Array obbligatorio',
        RulesEnum::ID_NOT_NULL->value => 'Questo campo non può essere null',
        RulesEnum::ID_NOT_EMPTY->value => 'Questo campo non può essere vuoto',
        RulesEnum::ID_NOT_EMPTY_STRING->value => 'Questo campo non può essere una stringa vuota',
    ],
    RulesEnum::ID_GROUP->value => [
        RulesEnum::ID_TYPE->value => 'Questo non è un group',
        RulesEnum::ID_REQUIRED->value => 'Array obbligatorio',
        RulesEnum::ID_NOT_NULL->value => 'Questo campo non può essere null',
        RulesEnum::ID_NOT_EMPTY->value => 'Questo campo non può essere vuoto',
        RulesEnum::ID_NOT_EMPTY_STRING->value => 'Questo campo non può essere una stringa vuota',
    ],
    'bool' => [
        RulesEnum::ID_TYPE->value => 'Tipo errato',
        RulesEnum::ID_REQUIRED->value => 'Valore obbligatorio',
    ],
    'number' => [
        RulesEnum::ID_BETWEEN->value => 'Numero fuori range',
        RulesEnum::ID_NOTBETWEEN->value => 'Numero fuori range',
        RulesEnum::ID_MIN->value => 'Numero troppo piccolo',
        RulesEnum::ID_MAX->value => 'Numero troppo grande',
    ],
    'float' => [
        RulesEnum::ID_TYPE->value => 'float: Tipo errato',
        RulesEnum::ID_REQUIRED->value => 'Valore obbligatorio',
    ],
    'int' => [
        RulesEnum::ID_TYPE->value => 'int: Tipo errato',
        RulesEnum::ID_REQUIRED->value => 'Valore obbligatorio',
    ],
    'intString' => [
        RulesEnum::ID_TYPE->value => 'La stringa deve contenere un valore intero',
        RulesEnum::ID_REQUIRED->value => 'Valore obbligatorio',
    ],
    'intBool' => [
        RulesEnum::ID_TYPE->value => 'Si accettano solo i valori 0 e 1',
        RulesEnum::ID_REQUIRED->value => 'Valore obbligatorio',
    ],
    'boolString' => [
        RulesEnum::ID_TYPE->value => 'La stringa deve essere o "true" o "false"',
        RulesEnum::ID_REQUIRED->value => 'Valore obbligatorio',
    ],
    'date' => [
        RulesEnum::ID_TYPE->value => 'La data non è valida',
        RulesEnum::ID_REQUIRED->value => 'Data obbligatoria',
        RulesEnum::ID_MIN->value => 'Data troppo lontana',
        RulesEnum::ID_MAX->value => 'Data troppo recente',
        RulesEnum::ID_BETWEEN->value => 'Data non nell\'intervallo permesso',
        RulesEnum::ID_NOTBETWEEN->value => 'Data non nell\'intervallo permesso',
    ],
    'email' => [
        RulesEnum::ID_TYPE->value => 'Email non valida',
        RulesEnum::ID_REQUIRED->value => 'L\'email è obbligatoria',
        RulesEnum::ID_NOT_NULL->value => 'L\'email non può essere null',
        RulesEnum::ID_NOT_EMPTY_STRING->value => 'L\'email non può essere vuota',
    ],
    'phone' => [
        RulesEnum::ID_TYPE->value => 'Telefono non valido',
        RulesEnum::ID_REQUIRED->value => 'Il telefono è obbliatorio',
        RulesEnum::ID_NOT_EMPTY->value => 'Il telefono non può essere vuoto',
    ],
];
