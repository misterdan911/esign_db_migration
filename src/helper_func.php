<?php

function prepareString($db, $string)
{
    if (empty($string)) return 'NULL';

    // trim left & right
    $string = trim($string);

    if (empty($string)) return 'NULL';

    // escape string
    $string = $db->escape_string($string);

    return "'$string'";
}

function parseDateTime($dateTime)
{
    if (empty($dateTime) || $dateTime == '0000-00-00 00:00:00') {
        $dateTime = "NULL";
    }
    else {
        $dateTime = "'$dateTime'";
    }

    return $dateTime;
}


function cleanInvalidUtf8($data) {
    $clean_data = str_replace("–", "-", $data);
    return $clean_data;
}

