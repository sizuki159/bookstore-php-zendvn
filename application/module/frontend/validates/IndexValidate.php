<?php
class IndexValidate extends Validate
{
    public function __construct($params)
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validateRegister($arrParam = null, $modelObj)
    {
        $queryUsername  = "SELECT `id` FROM `user` WHERE `username` = '{$arrParam['form']['username']}'";
        $queryEmail     = "SELECT `id` FROM `user` WHERE `email` = '{$arrParam['form']['email']}'";

        $this->addRule('username', 'string-notExistRecord', ['database' => $modelObj, 'query' => $queryUsername, 'min' => 3, 'max' => 50])
            ->addRule('email', 'email-notExistRecord', ['database' => $modelObj, 'query' => $queryEmail])
            ->addRule('password', 'password');
        $this->run();
    }

    public function validateProfile($arrParam = null)
    {
        $this->addRule('email', 'email');
        $this->run();
    }
}
