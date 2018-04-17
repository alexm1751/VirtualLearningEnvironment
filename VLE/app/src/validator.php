<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 30/03/2018
 * Time: 13:37
 */


use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;
class validator
{

    protected $errors;

    public function validate($request, array $rules){
        foreach ($rules as $field => $rule){
            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }

        }

        $_SESSION['errors'] = $this->errors;
        return $this;
    }

    public function failed(){
        return !empty($this->errors);
    }


}