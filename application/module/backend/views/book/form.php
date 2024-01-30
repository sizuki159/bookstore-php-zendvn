<?php
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];

$action             = isset($this->arrParam['id']) ? "form&id={$this->arrParam['id']}" : "form";
// Save
$linkSave           = URL::createLink($moduleName, $controllerName, $action, ['type' => 'save']);
$btnSave            = HTML::createActionButton("javascript:submitForm('$linkSave')", 'btn-success mr-1', 'Save');
// Save & Close
$linkSaveClose      = URL::createLink($moduleName, $controllerName, $action, ['type' => 'save-close']);
$btnSaveClose       = HTML::createActionButton("javascript:submitForm('$linkSaveClose')", 'btn-success mr-1', 'Save & Close');
// Save & New
$linkSaveNew        = URL::createLink($moduleName, $controllerName, $action, ['type' => 'save-new']);
$btnSaveNew         = HTML::createActionButton("javascript:submitForm('$linkSaveNew')", 'btn-success mr-1', 'Save & New');
// Cancel
$linkCancel         = URL::createLink($moduleName, $controllerName, 'index');
$btnCancel          = HTML::createActionButton($linkCancel, 'btn-danger mr-1', 'Cancel');

// Input
$dataForm           = $this->arrParam['form'];

$inputName              = Form::input('text', 'form[name]', 'form[name]', $dataForm['name'], 'form-control form-control-sm');
$inputDescription       = Form::textarea(10, 'form[description]', $dataForm['description'],'editor', 'form-control form-control-sm');
$inputPrice             = Form::input('number', 'form[price]', 'form[price]', $dataForm['price'], 'form-control form-control-sm');
$inputSaleOff           = Form::input('number', 'form[sale_off]', 'form[sale_off]', $dataForm['sale_off'], 'form-control form-control-sm');
$selectBoxCategory      = HTML::createSelectBox($this->listItemCategory, "form[category_id]", "custom-select custom-select-sm", null, "form[category_id]", null, $dataForm['category_id']);
$selectStatus           = Form::select('form[status]', 'custom-select custom-select-sm', array('default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive'), $dataForm['status']);
$selectSpecial          = Form::select('form[special]', 'custom-select custom-select-sm', array('default' => '- Select Special -', 'active' => 'Yes', 'inactive' => 'No'), $dataForm['special']);
$inputToken             = Form::input('hidden', 'form[token]', 'token', time());
$inputFileCurrent       = Form::input('hidden', 'form[file_current]', 'file_current', $dataForm['picture']);

$inputFilePicture       = Form::input('file', 'picture', 'admin-file-upload', null, 'form-control-file');

$inputID        = '';
$rowID          = '';
if (isset($this->arrParam['id'])) {
    $inputID    = Form::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
    $rowID      = Form::formGroup('ID', $inputID);
    $linkFilePicture    = URL::createLinkPicture('book', $dataForm['picture']);

    $rowShowPicture     = Form::formGroup('', '<img width="150px" height="auto" src="'.$linkFilePicture.'">');
}

// Row
$rowName            = Form::formGroup('Name', $inputName, true);
$rowDescription     = Form::formGroup('Description', $inputDescription, false);
$rowPrice           = Form::formGroup('Price', $inputPrice, true);
$rowSaleOff         = Form::formGroup('Sale Off', $inputSaleOff, false);
$rowCategory        = Form::formGroup('Category', $selectBoxCategory, true);
$rowStatus          = Form::formGroup('Status', $selectStatus, true);
$rowSpecial         = Form::formGroup('Special', $selectSpecial, true);
$rowFilePicture     = Form::formGroup('Picture', $inputFilePicture);

// MESSAGE
$error = $this->errors;
if (!empty($error)) {
    $message = $error;
} else {
    $message = HTML::showMessage();
}
?>

<?= $message ?>
<div class="card card-info card-outline">
    <div class="card-body">
        <form enctype="multipart/form-data" action="" method="post" class="mb-0" id="admin-form">
            <?= $rowID . $rowName . $rowDescription . $rowPrice . $rowSaleOff . $rowCategory . $rowStatus . $rowSpecial . $rowFilePicture . $rowShowPicture ?>
            <?= $inputToken . $inputFileCurrent ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel ?>
        </div>
    </div>
</div>