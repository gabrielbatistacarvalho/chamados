<?php

function genPassword(int $size)
{
        
    $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

    $key = '';
    for ($i = 0; $i < ($size + 10); $i++) 
    {
        $key .= $keys[array_rand($keys)];
    }

    $password = substr($key, 0, $size);

    return $password;
}
