<?php 

function is_int_not_negative($value){
    return preg_match("/^([^-]\d+|\d)$/", $value);
}

function navActive($segment)
{    
    return  request()->segment(1) === $segment ? 'active' : '';
}

function getExpiryOrderBy($expiry){
    $order_by = "desc";
    if($expiry == "latest"){
        $order_by = "desc";
    }else if($expiry == "oldest"){
        $order_by = "asc";
    }    
    return $order_by;
}

function increaseNumByPercent($number, $percent){
    return $number * ($percent / 100 + 1);
}

function getInputFloatPattern(){
    return 'pattern="^\d*(\.\d{0,2})?$"';
}

function negativeToZero($number){
    return $number < 0 ? 0 : $number;
}