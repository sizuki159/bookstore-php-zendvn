<?php
class IndexValidate extends Validate
{
    public function __construct($params)
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validate($database, $query)
    {
        $this->addRule('username', 'existRecord', ['database' => $database, 'query' => $query]);
        $this->run();
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
