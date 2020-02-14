<?php
namespace Core\Managers\FormValidator;
class SessionFormValidator implements FormValidatorInterface
{
    public function validate(array $request, array $formRules = [])
    {
        foreach ($request as $formKey=>$formValue)
        {
            $rules = $formRules[$formKey] ?? [];

            foreach ($rules as $rule)
            {
                $rule = explode(':', $rule);
                $method = $rule[0];
                $argument = $rule[1] ?? null;
                $validateMethodName = 'validate'.ucfirst($method);
                if(!$this->$validateMethodName($formValue, $argument))
                {
                    errors()->add(
                        $formKey,
                        sprintf(config("errors.$method", "Validation failed"),$formKey,$argument)//errors.min, errors.required
                    );
                }
            }
        }
    }
    public function passed():bool
    {
        return !errors()->any();
    }
    public function failed():bool
    {
        return ! $this->passed();
    }
    public function validateRequired($value, $argument): bool
    {
        return ! empty($value);
    }
    public function validateMin($value, $argument): bool
    {
        return strlen($value) >= (int) $argument;
    }
    public function validateMax($value, $argument): bool
    {
        return strlen($value) <= (int) $argument;
    }
    //contain at least 1 uppercase letter
    public function validateUpper($value, $argument): bool
    {
        return preg_match($argument, $value);
    }
    //contain at least 1  special char ( !@#$%^&*()_ )
    public function validateChar($value, $argument): bool
    {
        return preg_match($argument, $value);
    }
    //Password and confirm password should match
    public function validateMatch($value, $argument): bool
    {
        return $value === $argument;
    }

}