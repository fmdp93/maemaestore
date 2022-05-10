<?php 

function is_int_not_negative($value){
    return preg_match("/^([^-]\d+|\d)$/", $value);
}

function navActive($segment)
{    
    return  request()->segment(1) === $segment ? 'active' : '';
}