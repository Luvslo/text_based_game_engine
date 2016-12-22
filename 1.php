<?php
$fields = [
    'health_amount'

];

$text = '';

foreach ($fields as $field) {

    $method = str_replace('_', '', ucwords($field, '_'));



    $text .= 'public function get' . $method . '()'."\n";

    $text .= '{'.PHP_EOL;

    $text .= "\t" . 'return $this->' . $field .';'.PHP_EOL;

    $text .= '}'.PHP_EOL;

    $text .= PHP_EOL;

    $text .= 'public function set' . $method . '($' . $field . ')'."\n";

    $text .= '{'.PHP_EOL;

    $text .= "\t" . 'return $this->' . $field .' = $' . $field . ';'.PHP_EOL;

    $text .= '}'.PHP_EOL;

    $text .= PHP_EOL;
}

echo $text;