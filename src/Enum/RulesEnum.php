<?php

declare(strict_types=1);

namespace Kedniko\VivyPluginStandard\Enum;

enum RulesEnum: string
{
  case ID_TYPE = 'type';
  case ID_NOT_EMPTY = 'notEmpty';
  case ID_EMPTY = 'empty';
  case ID_LENGTH = 'length';
  case ID_MINLENGTH = 'minLength';
  case ID_MAXLENGTH = 'maxLength';
  case ID_REGEX = 'regex';

  case ID_BETWEEN = 'between';
  case ID_NOTBETWEEN = 'notBetween';

  case ID_NOT_FALSY = 'notFalsy';
  case ID_MIN_DATE = 'minDate';
  case ID_MAX_DATE = 'maxDate';
  case ID_DATE_BETWEEN = 'dateBetween';
  case ID_DATE_NOT_BETWEEN = 'dateNotBetween';
  case ID_STRING = 'string';
  case ID_INTSTRING = 'intString';
  case ID_DIGITS_STRING = 'digitsString';
  case ID_INTBOOL = 'intBool';
  case ID_FILE = 'file';
  case ID_INT = 'int';
  case ID_FLOAT = 'float';
  case ID_NUMBER = 'number';
  case ID_FLOAT_OR_INT = 'floatOrInt';
  case ID_FLOAT_STRING = 'floatString';
  case ID_BOOL = 'bool';
  case ID_BOOL_STRING = 'boolString';
  case ID_EMAIL = 'email';
  case ID_PHONE = 'phone';
  case ID_DATE = 'date';
  case ID_MIN = 'min';
  case ID_MAX = 'max';
  case ID_ARRAY = 'array';
  case ID_ORDERED_INDEXED_ARRAY = 'orderedIndexedArray';
  case ID_SCALAR = 'scalar';
  case ID_IN_ARRAY = 'inArray';
  case ID_NOT_IN_ARRAY = 'notInArray';
  case ID_UNDEFINED = 'undefined';
  case ID_SET_VALUE = 'setValue';
}
