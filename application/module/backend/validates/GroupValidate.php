<?php
class GroupValidate extends Validate {
    public function __construct($params) 
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validate()
    {
        $this->addRule('name', 'string', ['min' => 2, 'max' => 50])
            ->addRule('status', 'status', ['deny' => ['default']])
            ->addRule('group_acp', 'status', ['deny' => ['default']]);
        $this->run();
    }
}