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

$inputName          = Form::input('text', 'form[name]', 'name', $dataForm['name'], 'form-control form-control-sm');
$inputDescription   = Form::input('text', 'form[description]', 'name', $dataForm['description'], 'form-control form-control-sm');
$inputLink          = Form::input('text', 'form[link]', 'name', $dataForm['link'], 'form-control form-control-sm');
$inputToken         = Form::input('hidden', 'form[token]', 'token', time());
$inputFileCurrent   = Form::input('hidden', 'form[file_current]', 'file_current', $dataForm['picture']);
$selectStatus       = Form::select('form[status]', 'custom-select custom-select-sm', array('default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive'), $dataForm['status']);
$inputFilePicture   = Form::input('file', 'picture', 'admin-file-upload', null, 'form-control-file');

$inputID        = '';
$rowID          = '';
if (isset($this->arrParam['id'])) {
    $inputID    = Form::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
    $rowID      = Form::formGroup('ID', $inputID);
    $linkFilePicture    = URL::createLinkPicture('slider', $dataForm['picture']);

    $rowShowPicture = Form::formGroup('', '<img width="450px" height="auto" src="'.$linkFilePicture.'">');
}
// Row
$rowName        = Form::formGroup('Name', $inputName, true);
$rowDescription = Form::formGroup('Description', $inputDescription);
$rowLink        = Form::formGroup('Link', $inputLink);
$rowStatus      = Form::formGroup('Status', $selectStatus, true);
$rowFilePicture = Form::formGroup('Picture', $inputFilePicture);

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
            <?= $rowID . $rowName . $rowDescription . $rowLink . $rowStatus . $rowFilePicture . $rowShowPicture?>
            <?= $inputToken . $inputFileCurrent ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel ?>
        </div>
    </div>
</div>