<?php
class SliderValidate extends Validate {
    public function __construct($params) 
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validate()
    {
        $this->addRule('name', 'string', ['min' => 2, 'max' => 255])
            ->addRule('status', 'status', ['deny' => ['default']]);
        $this->run();
    }
}