<?php
class UserValidate extends Validate {
    public function __construct($params) 
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validate($arrParam = null)
    {
        $this->addRule('username', 'string', ['min' => 2, 'max' => 50])
            ->addRule('email', 'email')
            ->addRule('fullname', 'string', ['min' => 5, 'max' => 100])
            ->addRule('status', 'status', ['deny' => ['default']])
            ->addRule('group_id', 'status', ['deny' => ['default']]);
        if(!isset($arrParam['form']['id']))
        {
            $this->addRule('password', 'password');
        }
        $this->run();
    }

    public function validateResetPassword()
    {
        $this->addRule('new_password', 'password');
        $this->run();
    }
}