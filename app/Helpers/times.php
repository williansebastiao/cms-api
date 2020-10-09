<?php

// RECUPERA APENAS O HORÁRIO
function hours($time){
    return date('H:i', strtotime($time));
}

// RECUPERA APENAS O HORÁRIO
function fullHours($time){
    return date('H:i:s', strtotime($time));
}
