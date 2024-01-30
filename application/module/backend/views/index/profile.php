<?php
$moduleName     = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName     = $this->arrParam['action'];

// Save
$linkSave           = URL::createLink($moduleName, $controllerName, $actionName, ['type' => 'save']);
$btnSave            = HTML::createActionButton("javascript:submitForm('$linkSave')", 'btn-success mr-1', 'Save');
// Cancel
$linkCancel         = URL::createLink($moduleName, $controllerName, 'index');
$btnCancel          = HTML::createActionButton($linkCancel, 'btn-danger mr-1', 'Cancel');

// Input
$dataForm           = $this->arrParam['form'];


$inputEmail         = Form::input('email', 'form[email]', 'email', $dataForm['email'], 'form-control form-control-sm');
$inputFullname      = Form::input('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'form-control form-control-sm');
$inputUsername      = Form::input('text', 'form[fullname]', 'fullname', $dataForm['username'], 'form-control form-control-sm', 'readonly');

$inputToken         = Form::input('hidden', 'form[token]', 'token', time());


$inputID            = Form::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
$rowID              = Form::formGroup('ID', $inputID, true);

// Row
$rowUsername        = Form::formGroup('Username', $inputUsername, true);
$rowEmail           = Form::formGroup('Email', $inputEmail, true);
$rowFullname        = Form::formGroup('Fullname', $inputFullname);


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
            <?= $rowID . $rowUsername . $rowEmail . $rowFullname ?>
            <?= $inputToken ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnCancel ?>
        </div>
    </div>
</div>