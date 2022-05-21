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