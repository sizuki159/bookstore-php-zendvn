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
    $name               = HTML::highLight($item['name'], $searchValue);
    $linkFilePicture    = URL::createLinkPicture('book', $item['picture']);
    $price              = HTML::formatCurrency($item['price']);
    $saleOff            = HTML::highLight($item['sale_off'], $searchValue);
    $selectBoxCategory  = HTML::createSelectBox($this->listItemCategory, "select-category", "custom-select custom-select-sm", "width: unset", $item['id'], $item['id'], $item['category_id']);
    $linkStatus         = URL::createLink($moduleName, $controllerName, 'changeStatus', ['id' => $item['id'], 'status' => $item['status']]);
    $status             = HTML::showItemState($linkStatus, $item['status']);
    $linkSpecial        = URL::createLink($moduleName, $controllerName, 'changeBookSpecial', ['id' => $item['id'], 'special' => $item['special']]);
    $special            = HTML::showItemState($linkSpecial, $item['special'], true);
    $created            = HTML::showItemHistory($item['created_by'], $item['created']);
    $modified           = HTML::showItemHistory($item['modified_by'], $item['modified']);
    $editLink           = URL::createLink($moduleName, $controllerName, 'form', ['id' => $item['id']]);
    $deleteLink         = URL::createLink($moduleName, $controllerName, 'delete', ['id' => $item['id']]);

    $xhtml .= '
    <tr class="">
        <td class="text-center">
            '.$checkbox.'
        </td>
        <td class="text-center">'.$id.'</td>
        <td class="text-center position-relative">
            '.$name.'
        </td>
        <td style="width: 100px; padding: 5px">
            <img class="item-image w-100" src="'.$linkFilePicture.'">
        </td>
        <td class="text-center">
            '.$price.'
        </td>
        <td class="text-center">
            '.$saleOff. '%'.'
        </td>
        <td class="text-center position-relative">
        '.$selectBoxCategory.'
        </td>
        <td class="text-center">
            '.$status.'
        </td>
        <td class="text-center position-relative">
            '.$special.'
        </td>
        <td class="text-center position-relative">
            <input type="number" name="chkOrdering['.$item['id'].']" value="'.$item['ordering'].'" class="chkOrdering form-control form-control-sm m-auto text-center" style="width: 65px" id="chkOrdering['.$item['id'].']" data-id="'.$item['id'].'" min="1">
        </td>
        <td class="text-center">
            '.$created.'
        </td>
        <td class="text-center modified-' . $item['id'] . '">
            '.$modified.'
        </td>
        <td class="text-center">
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