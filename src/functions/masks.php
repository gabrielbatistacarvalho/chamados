<?php

 function apply(string $string, string $mask)
{
    $maskared = '';
    $k = 0;

    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($string[$k])) $maskared .= $string[$k++];
        } else {
            if (isset($mask[$i])) {
                if ($mask[$i] == $string[$k]) {
                    $k++;
                }
                $maskared .= $mask[$i];
            }
        }
    }

    return $maskared;
}

function maskCnpj(string $cnpj): string
{
        return apply($cnpj, '##.###.###/####-##');
}

function maskPhone(string $phone): string
{
        return apply($phone, '+## (##) #####-####');
}

?>