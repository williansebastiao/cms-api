<?php

function mask($mask, $str){
    $str = str_replace(" ","",$str);
    for($i = 0; $i < strlen($str); $i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
}

function ie($uf, $value){
    switch($uf) {
        case 'ac':
            return mask('##.###.###/###-##', $value);
        case 'al':
        case 'ap':
        case 'ma':
        case 'mt':
        case 'ms':
        case 'pi':
            return mask('#########', $value);
        case 'am':
        case 'go':
            return mask('##.###.###-#', $value);
        case 'mg':
        case 'mg':
            return mask('###.###.###/####', $value);
        case 'ba':
        case 'es':
            return mask('###.###.##-#', $value);
        case 'ce':
        case 'pb':
            return mask('########-#', $value);
        case 'df':
            return mask('###########-##', $value);
        case 'pa':
            return mask('##-######-#', $value);
        case 'pr':
            return mask('########-##', $value);
        case 'pe':
            return mask('##.#.###.#######-#', $value);
        case 'rj':
            return mask('##.###.##-#', $value);
        case 'ro':
            return mask('###.#####-#', $value);
        case 'rs':
            return mask('###-#######', $value);
        case 'sc':
            return mask('###.###.###', $value);
        case 'sp':
            return mask('###.###.###.###', $value);
        case 'se':
            return mask('#########-#', $value);
        case 'to':
            return mask('###########', $value);
    }
}

// CONVERTE VALOR PARA DECIMAL
function decimal($value){
    return 'R$ ' . number_format($value, 2, ',', '.');
}
