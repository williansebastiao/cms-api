<?php

function clearSpecialCharacters($value){
    $str = str_replace('-', '', $value);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
}
