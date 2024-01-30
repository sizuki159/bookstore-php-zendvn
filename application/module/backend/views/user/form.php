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

$inputUsername        = Form::input('text', 'form[username]', 'name', $dataForm['username'], 'form-control form-control-sm');
$inputEmail      = Form::input('email', 'form[email]', 'email', $dataForm['email'], 'form-control form-control-sm');
$inputFullname      = Form::input('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'form-control form-control-sm');
$inputToken        = Form::input('hidden', 'form[token]', 'token', time());
$selectStatus    = Form::select('form[status]', 'custom-select custom-select-sm', array('default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive'), $dataForm['status']);
$selectBoxGroup = HTML::createSelectBox($this->listItemGroup, "form[group_id]", "custom-select custom-select-sm", null, "form[group_id]", null, $dataForm['group_id']);

$inputID        = '';
$rowID            = '';
$inputPassword      = Form::input('password', 'form[password]', 'password', $dataForm['password'], 'form-control form-control-sm');
$rowPassword        = Form::formGroup('Password', $inputPassword, true);
if (isset($this->arrParam['id'])) {
    $inputID    = Form::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
    $rowID        = Form::formGroup('ID', $inputID);
    $inputPassword = '';
    $rowPassword = '';
}
// Row
$rowUsername        = Form::formGroup('Username', $inputUsername, true);
$rowEmail    = Form::formGroup('Email', $inputEmail, true);
$rowFullname   = Form::formGroup('Fullname', $inputFullname, true);
$rowStatus    = Form::formGroup('Status', $selectStatus, true);
$rowGroup   = Form::formGroup('Group', $selectBoxGroup, true);

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
            <?= $rowID . $rowUsername . $rowPassword . $rowEmail . $rowFullname . $rowStatus . $rowGroup ?>
            <?= $inputToken ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel ?>
        </div>
    </div>
</div>