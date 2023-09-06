<?php

function filterCnpj(string $cnpj)
{
    $filter = str_replace('.', '', $cnpj);
    $filter = str_replace('/', '', $filter);
    $filter = str_replace('-', '', $filter);

    return filterChars($filter);
}

function filterPhone(string $phone)
{
    $filter = str_replace('+', '', $phone);
    $filter = str_replace('(', '', $filter);
    $filter = str_replace(')', '', $filter);
    $filter = str_replace('-', '', $filter);
    $filter = str_replace(' ', '', $filter);

    return filterChars($filter);
}

function filterChars(string $string)
{
    $filter = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    $filter = trim($filter);
        
    return $filter;
}

?>
