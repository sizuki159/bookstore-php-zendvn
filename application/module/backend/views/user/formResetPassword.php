<?php
$moduleName = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName = $this->arrParam['action'];

$action             = isset($this->arrParam['id']) ? "resetPassword&id={$this->arrParam['id']}" : "resetPassword";
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
// BTN RandomPass
$btnRandomPass      = HTML::createActionButton("", 'btn-info mr-1 btn-random-string', "Generate Password");


// Input
$dataForm         = $this->arrParam['form'];

$inputUsername        = Form::input('text', 'form[username]', 'name', $dataForm['username'], 'form-control form-control-sm', 'readonly');
$inputEmail      = Form::input('email', 'form[email]', 'email', $dataForm['email'], 'form-control form-control-sm', 'readonly');
$inputFullname      = Form::input('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'form-control form-control-sm', 'readonly');
$inputToken        = Form::input('hidden', 'form[token]', 'token', time());


$inputID    = Form::input('text', 'form[id]', 'id', $dataForm['id'], 'form-control form-control-sm', 'readonly');
$rowID        = Form::formGroup('ID', $inputID);

$newPasswordRandom = Helper::generateRandomString();
$inputNewPassword      = Form::input('text', 'form[new_password]', 'password', $newPasswordRandom, 'form-control form-control-sm');
$rowNewPassword        = Form::formGroup('New Password', $inputNewPassword, true);
    
// Row
$rowUsername        = Form::formGroup('Username', $inputUsername, true);
$rowEmail    = Form::formGroup('Email', $inputEmail, true);
$rowFullname   = Form::formGroup('Fullname', $inputFullname, true);
$rowBtnRandomPassword = Form::formGroup(null, $btnRandomPass, false);

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
            <?= $rowID . $rowUsername . $rowEmail . $rowFullname . $rowNewPassword ?>
            <?= $inputToken ?>
        </form>
        <?= $rowBtnRandomPassword; ?>
    </div>

    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnSaveClose . $btnCancel ?>
        </div>
    </div>
</div>