<?php
$xhtml = '';
$moduleName = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName = $this->arrParam['action'];
$searchValue = $this->arrParam['search'] ?? '';
foreach ($this->items as $item)
{
    $checkbox           = HTML::showItemCheckbox($item['id']);
    $id                 = HTML::highLight($item['id'], $searchValue);
    $username           = HTML::highLight($item['username'], $searchValue);
    $fullname           = HTML::highLight($item['fullname'], $searchValue);
    $email              = HTML::highLight($item['email'], $searchValue);
    $infoUser           = HTML::showInfoUser($username, $fullname, $email);
    $selectBoxGroup     = HTML::createSelectBox($this->listItemGroup, "select-group", "custom-select custom-select-sm", "width: unset", $item['id'], $item['id'], $item['group_id']);
    $linkStatus         = URL::createLink($moduleName, $controllerName, 'changeStatus', ['id' => $item['id'], 'status' => $item['status']]);
    $status             = HTML::showItemState($linkStatus, $item['status']);
    $created            = HTML::showItemHistory($item['created_by'], $item['created']);
    $modified           = HTML::showItemHistory($item['modified_by'], $item['modified']);
    $editPasswordLink   = URL::createLink($moduleName, $controllerName, 'resetPassword', ['id' => $item['id']]);
    $editLink           = URL::createLink($moduleName, $controllerName, 'form', ['id' => $item['id']]);
    $deleteLink         = URL::createLink($moduleName, $controllerName, 'delete', ['id' => $item['id']]);

    $xhtml .= '
    <tr class="">
        <td class="text-center">
            '.$checkbox.'
        </td>
        <td class="text-center">'.$id.'</td>
        <td>
            '.$infoUser.'
        </td>
        <td class="text-center position-relative">
            '.$selectBoxGroup.'
        </td>
        <td class="text-center position-relative">
            '.$status.'
        </td>
        <td class="text-center">
            '.$created.'
        </td>
        <td class="text-center modified-' . $item['id'] . '">
            '.$modified.'
        </td>
        <td class="text-center">
            <a href="'.$editPasswordLink.'" class="rounded-circle btn btn-sm btn-secondary" title="Change Password">
                <i class="fas fa-key"></i>
            </a>

            <a href="'.$editLink.'" class="rounded-circle btn btn-sm btn-info" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </a>

            <a href="'.$deleteLink.'" class="rounded-circle btn btn-sm btn-danger btn-delete-item" title="Delete">
                <i class="fas fa-trash-alt"></i>
            </a>
        </td>
    </tr>
    ';
}

?>
<?= HTML::showMessage() ?>
<!-- Search & Filter -->
<?php require_once 'elements/search-filter.php' ?>

<!-- List -->
<?php require_once 'elements/list.php' ?>