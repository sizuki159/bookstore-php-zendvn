<?php
$xhtml = '';
$moduleName = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName = $this->arrParam['action'];
$searchValue = $this->arrParam['search'] ?? '';
foreach ($this->items as $item) {
    $checkbox       = HTML::showItemCheckbox($item['id']);
    $id             = HTML::highLight($item['id'], $searchValue);
    $name           = HTML::highLight($item['name'], $searchValue);
    $linkStatus     = URL::createLink($moduleName, $controllerName, 'changeStatus', ['id' => $item['id'], 'status' => $item['status']]);
    $linkGroupACP   = URL::createLink($moduleName, $controllerName, 'changeGroupACP', ['id' => $item['id'], 'group_acp' => $item['group_acp']]);
    $status         = HTML::showItemState($linkStatus, $item['status']);
    $groupACP       = HTML::showItemState($linkGroupACP, $item['group_acp'], true);
    $created        = HTML::showItemHistory($item['created_by'], $item['created']);
    $modified       = HTML::showItemHistory($item['modified_by'], $item['modified']);
    $editLink       = URL::createLink($moduleName, $controllerName, 'form', ['id' => $item['id']]);
    $deleteLink     = URL::createLink($moduleName, $controllerName, 'delete', ['id' => $item['id']]);
    $xhtml .= '
    <tr>
        <td class="text-center">' . $checkbox . '</td>
        <td class="text-center">' . $id . '</td>
        <td class="text-center">' . $name . '</td>
        <td class="text-center position-relative">' . $status . '</td>
        <td class="text-center position-relative">' . $groupACP . '</td>
        <td class="text-center">' . $created . '</td>
        <td class="text-center modified-' . $item['id'] . '">' . $modified . '</td>
        <td class="text-center">
            <a href="' . $editLink . '" class="rounded-circle btn btn-sm btn-info" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <a href="' . $deleteLink . '" class="rounded-circle btn btn-sm btn-danger btn-delete-item" title="Delete">
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