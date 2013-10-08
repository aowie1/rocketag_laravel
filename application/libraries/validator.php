<?php
/**
 * Extension to the Laravel Validator
 * Allows us to define custom validation rules and replace methods for custom error messages
 * 
 */
class Validator extends Laravel\Validator 
{   
    /**
     * Validate a password
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    protected function validate_password($attribute, $value, $parameters)
    {
        return $this->validate_match($attribute, $value, $parameters);
    }
}