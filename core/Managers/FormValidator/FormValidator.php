<?php
namespace Core\Managers\FormValidator;
class FormValidator{
    public static function get()
    {
        return new SessionFormValidator();
    }
}