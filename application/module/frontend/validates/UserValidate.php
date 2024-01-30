<?php
class UserValidate extends Validate
{
    public function __construct($params)
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validateProfile($arrParam = null)
    {
        $this->addRule('email', 'email');
        $this->run();
    }

    public function validateChangePassword($arrParam = null)
    {
        $this->addRule('new_pass', 'password')
            ->addRule('new_pass_again', 'password');
        $this->run();
    }
}
