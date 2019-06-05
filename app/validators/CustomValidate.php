<?php

/**
* Classe única e exclusiva p/ aplicação de novos metodos de validação
* @author Rafael Domingues Teixeira
*/

class CustomValidate extends Illuminate\Validation\Validator {

  /**
  * Validador de data mínima a ser inserida
  * @param string $value - Valor informado
  * @param string $param - Data mínima atribuida
  * @author Rafael Domingues Teixeira
  */
  public function validateMinDate($attribute, $value, $param){
    $value = FormatterHelper::brToEnDate($value);
    $param[0] = FormatterHelper::brToEnDate($param[0]);
    return (strtotime($value) < strtotime($param[0])) ? false : true;
  }

  protected function replaceMinDate($message, $attribute, $rule, $parameters){
    return str_replace(':mindate', $parameters[0], $message);
  }

  /**
  * Validador de valores duplicados dentro de um array
  * @param array $value - array informado
  * @author Rafael Domingues Teixeira
  */
  public function validateDuplicate($attribute, $value, $parameters){
    if(count(array_unique($value))<count($value)){
      return false;
    }
    return true;
  }

  protected function replaceDuplicate($message, $attribute, $rule, $parameters){
    return str_replace(':duplicate', $attribute, $message);
  }

  /**
  * Validador de CPF
  * @param array $value - numero de cpf
  * @author Rafael Domingues Teixeira
  */
  public function validateCpf($attribute, $value, $parameters) {
      $input['cpf'] = $value;

      $j=0;
      for($i=0; $i<(strlen($input['cpf'])); $i++)
          {
            if(is_numeric($input['cpf'][$i]))
              {
                  $num[$j]=$input['cpf'][$i];
                  $j++;
              }
          }
      if($j==0)
          return false;

      if(count($num)!=11){
              return false;
          }
      else{
        for($i=0; $i<10; $i++){
            if ($num[0]==$i && $num[1]==$i && $num[2]==$i && $num[3]==$i && $num[4]==$i && $num[5]==$i && $num[6]==$i && $num[7]==$i && $num[8]==$i){
                    return false;
                    break;
                }
            }
        }
      if(!isset($isCpfValid)){
          $j=10;
          for($i=0; $i<9; $i++){
              $multiplica[$i]=$num[$i]*$j;
              $j--;
          }
          $soma = array_sum($multiplica);
          $resto = $soma%11;
          if($resto<2){
                  $dg=0;
          }else{
              $dg=11-$resto;
          }
          if($dg!=$num[9]){
              return false;
          }
      }

      if(!isset($isCpfValid)){
          $j=11;
          for($i=0; $i<10; $i++){
              $multiplica[$i]=$num[$i]*$j;
              $j--;
          }
          $soma = array_sum($multiplica);
          $resto = $soma%11;
          if($resto<2){
                  $dg=0;
          }else{
            $dg=11-$resto;
          }
          if($dg!=$num[10]){
            return false;
          }else{
            return true;
          }
      }
      return true;
  }

  protected function replaceCPF($message, $attribute, $rule, $parameters)
  {
      if(count($parameters) > 0)
          return str_replace(':cpf', $parameters, $message);
      else
          return $message;
  }
}
