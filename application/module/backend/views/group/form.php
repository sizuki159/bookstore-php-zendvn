<?php
$moduleName = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName = $this->arrParam['action'];

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
$dataForm         = $this->arrParam['form'];

$inputName        = Form::input('text', 'form[name]', 'name', $dataForm['name'], 'form-control form-control-sm');
$inputToken        = Form::input('hidden', 'form[token]', 'token', time());
$selectStatus    = Form::select('form[status]', 'custom-select custom-select-sm', array('default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive'), $dataForm['status']);
$selectGroupACP    = Form::select('form[group_acp]', 'custom-select custom-select-sm', array('default' => '- Select Group ACP -', 1 => 'Yes', 0 => 'No'), $dataForm['group_acp']);

$inputID        = '';
$rowID            = '';
if (isset($this->arrParam['id'])) {
    $inputID    = Form::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
    $rowID        = Form::formGroup('ID', $inputID);
}
// Row
$rowName        = Form::formGroup('Name', $inputName, true);
$rowStatus        = Form::formGroup('Status', $selectStatus, true);
$rowGroupACP    = Form::formGroup('Group ACP', $selectGroupACP, true);

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
        <form action="" method="post" class="mb-0" id="admin-form">
            <?= $rowID . $rowName . $rowStatus . $rowGroupACP ?>
            <?= $inputToken ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel ?>
        </div>
    </div>
</div>