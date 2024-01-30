<?php
class BookValidate extends Validate {
    public function __construct($params) 
    {
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    public function validate($arrParam = null)
    {
        $this->addRule('name', 'string', ['min' => 3, 'max' => 100])
            ->addRule('price', 'int', ['min' => 0, 'max' => 100000000])
            ->addRule('category_id', 'status', ['deny' => ['default']])
            ->addRule('status', 'status', ['deny' => ['default']])
            ->addRule('special', 'status', ['deny' => ['default']]);
            $this->run();
    }

}