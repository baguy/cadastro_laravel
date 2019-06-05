<?php

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('array_full', function($attribute, $value, $parameters)
{
    $is_full = (in_array('', $value)) ? false : true;
    
    return $is_full;
});

Validator::extend('array_unique', function($attribute, $value, $parameters)
{
    return count($value) == count(array_unique($value));
});

Validator::extend('array_numeric', function($attribute, $value, $parameters)
{
    $numeric_values = array_filter($value, create_function('$item', 'return (is_numeric($item));'));
    
    return count($numeric_values) == count($value);
});

Validator::extend('password_verify', function ($attribute, $value, $parameters) 
{
    return Hash::check($value, Auth::user()->getAuthPassword());
});

Validator::extend('required_if_date_lt_1', function ($attribute, $value, $parameters) 
{

    $required = false;

    $date = Input::get($parameters[0]);

    $age = Carbon\Carbon::now()->diff(new Carbon\Carbon(Helper::dateMySQL($date)))->y;

    $minAge = $parameters[2];

    switch ($parameters[1]) {
                
        case "==":
            $required = $age == $minAge;
            break;
        case "!=":
            $required = $age != $minAge;
            break;
        case "===":
            $required = $age === $minAge;
            break;
        case "!==":
            $required = $age !== $minAge;
            break;
        case "<":
            $required = $age < $minAge;
            break;
        case "<=":
            $required = $age <= $minAge;
            break;
        case ">":
            $required = $age > $minAge;
            break;
        case ">=":
            $required = $age >= $minAge;
            break;
    }

    return $required && is_null($value) ? false : true;
});

Validator::extend('required_if_date_lt_2', function ($attribute, $value, $parameters) 
{

    $required = false;

    $age = Carbon\Carbon::now()->diff(new Carbon\Carbon(Helper::dateMySQL($value)))->y;

    $required = $age < 18;

    return !$required;

    //return (new DateTime)->diff(new DateTime($value))->y >= $minAge;

    // or the same using Carbon:
    // return Carbon\Carbon::now()->diff(new Carbon\Carbon($value))->y >= $minAge;
});

Validator::extend('date_pt_br', function($attribute, $value)
{
    $data = explode("/", $value);
    $d = $data[0];
    $m = $data[1];
    $y = $data[2];
    
    if($y < (date("Y") - 100)) {
        
        return FALSE;
    }

    // verifica se a data é válida!
    $res = checkdate($m, $d, $y);
    
    // 1 = true (válida)
    if ($res == 1) {
        
        return TRUE;
        
    // 0 = false (inválida)    
    } else {
        
        return FALSE;
    }
});

Validator::extend('cpf', function($attribute, $value)
{
    //Salva em CPF (apenas numeros), isso permite receber o CPF em diferentes formatos, assim como "000.000.000-00", "00000000000", "000 000 000 00"
    $cpf = preg_replace('/\D/', '', $value);
    
    //Cria um array com os valores
    $num = array();
    
    for ($i = 0; $i < (strlen($cpf)); $i++) {

        $num[] = $cpf[$i];
    }
    
    if (count($num) !== 11) {
        
        return false;
        
    } else {
        
        //Limpando combinações como 00000000000, 11111111111, ...
        for ($i = 0; $i < 10; $i++) {
            if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i && $num[9] == $i && $num[10] == $i) {
                return false;
                //break;
            }
        }
    }
    
    //Calcula e compara o primeiro dígito verificador
    $j = 10;
    
    for ($i = 0; $i < 9; $i++) {
        
        $multiplica[$i] = $num[$i] * $j;
        $j--;
    }
    
    $soma_01 = array_sum($multiplica);
    
    $resto_01 = $soma_01 % 11;
    
    if ($resto_01 < 2) {
        
        $dg = 0;
        
    } else {
        
        $dg = 11 - $resto_01;
    }
    
    if ($dg != $num[9]) {
        
        return false;
    }
    
    //Calcula e compara o segundo dígito verificador
    $z = 11;
    
    for ($i = 0; $i < 10; $i++) {
        
        $multiplica[$i] = $num[$i] * $z;
        $z--;
    }
    
    $soma_02 = array_sum($multiplica);
    
    $resto_02 = $soma_02 % 11;
    
    if ($resto_02 < 2) {
        
        $dg = 0;
        
    } else {
        
        $dg = 11 - $resto_02;
    }
    
    if ($dg != $num[10]) {
        
        return false;
        
    } else {
        
        return true;
    }
});