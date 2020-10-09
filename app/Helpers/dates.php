<?php
//CONVERTE DATA PARA MYSQL/MONGO
function database($date){
    return implode('-', array_reverse(explode('/', $date)));
}

//CONVERTER DATE PARA BRASIL(d/m/Y)
function brazil($date){
    return date('d/m/Y', strtotime($date));
}

// CONVERTER DATE PARA BRASIL(d/m)
function shortBrazil($date){
    return date('d/m', strtotime($date));
}

// RECUPERA APENAS MÊS
function month($date){
    $mySql = setDateBrazil($date);
    $month = date('M', strtotime($mySql));

    switch($month) {
        case 'Jan':
            return $res = 'Jan';
        case 'Feb':
            return $res = 'Fev';
        case 'Mar':
            return $res = 'Mar';
        case 'Apr':
            return $res = 'Abr';
        case 'May':
            return $res = 'Maio';
        case 'June':
            return $res = 'Jun';
        case 'July':
            return $res = 'Jul';
        case 'Aug':
            return $res = 'Ago';
        case 'Sept':
            return $res = 'Set';
        case 'Oct':
            return $res = 'Out';
        case 'Nov':
            return $res = 'Nov';
        case 'Dec':
            return $res = 'Dez';
    }
}

// EXIBE A SEMANA
function week($date){
    $week = date('l', strtotime($date));

    switch($week){
        case 'Sunday':
            return $ret = 'Domingo';
        case 'Monday':
            return $ret = 'Segunda-feira';
        case 'Tuesday':
            return $ret = 'Terça-feira';
        case 'Wednesday':
            return $ret = 'Quarta-feira';
        case 'Thursday':
            return $ret = 'Quinta-feira';
        case 'Friday':
            return $ret = 'Sexta-feira';
        case 'Saturday':
            return $ret = 'Sábado';
    }
}
