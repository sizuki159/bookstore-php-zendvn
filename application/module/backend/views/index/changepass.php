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
$inputOldPassword       = Form::input('password', 'form[old_pass]', 'form[old_pass]', null, 'form-control form-control-sm');
$inputNewPassword       = Form::input('password', 'form[new_pass]', 'form[new_pass]', null, 'form-control form-control-sm');
$inputNewPasswordAgain  = Form::input('password', 'form[new_pass_again]', 'form[new_pass_again]', null, 'form-control form-control-sm');

$inputToken         = Form::input('hidden', 'form[token]', 'token', time());



// Row
$rowOldPassword         = Form::formGroup('Old Password', $inputOldPassword, true);
$rowNewdPassword        = Form::formGroup('New Password', $inputNewPassword, true);
$rowNewPasswordAgain    = Form::formGroup('New Password Again', $inputNewPasswordAgain, true);


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
            <?= $rowOldPassword . $rowNewdPassword . $rowNewPasswordAgain ?>
            <?= $inputToken ?>
        </form>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-8 offset-sm-2">
            <?= $btnSave . $btnCancel ?>
        </div>
    </div>
</div>