<?php

declare(strict_types=1);

namespace Kedniko\VivyPluginStandard\Enum;

enum TransformersEnum: string
{
  case ID_STRING_TO_BOOL = 'stringToBool';
  case ID_BOOL_VALUE_TO_BOOL = 'boolValueToBool';
  case ID_INT_VALUE_TO_INT = 'intValueToInt';
  case ID_STRING_TO_INT = 'stringToInt';
  case ID_BOOL_TO_INT = 'boolToInt';
  case ID_BOOL_TO_STRING = 'boolToString';
  case ID_INT_TO_STRING = 'intToString';
  case ID_INT_TO_BOOL = 'intToBool';
  case ID_TRIM = 'trim';
  case ID_LTRIM = 'ltrim';
  case ID_RTRIM = 'rtrim';
  case ID_TO_UPPER_CASE = 'toUpperCase';
  case ID_TO_LOWER_CASE = 'toLowerCase';
  case ID_FIRST_LETTER_UPPER_CASE = 'firstLetterUpperCase';
  case ID_FIRST_LETTER_LOWER_CASE = 'firstLetterLowerCase';
  case ID_NUMBER_TO_STRING = 'numberToString';
}
