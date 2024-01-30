<?php
$xhtml = '';
$moduleName = $this->arrParam['module'];
$controllerName = $this->arrParam['controller'];
$actionName = $this->arrParam['action'];
$searchValue = $this->arrParam['search'] ?? '';
foreach ($this->items as $item)
{
    $item['books']      = json_decode($item['books']);
    $item['prices']     = json_decode($item['prices']);
    $item['quantities'] = json_decode($item['quantities']);
    $item['names']      = json_decode($item['names']);

    $detail             = "";
    $totalPrice         = 0;
    foreach($item['books'] as $key => $value)
    {
        $bookID     = $value['id'];
        $bookName   = $item['names'][$key];
        $quantity   = $item['quantities'][$key];
        $price      = $item['prices'][$key] * $quantity;
        $detail     .= '<p><b>'.$bookName.'</b> x <span style="background-color:yellow; border-radius:450%; width:100px;">' . $quantity . '</span> = '.HTML::formatCurrency($price).'</p>';
        $totalPrice += $price;
    }

    $checkbox           = HTML::showItemCheckbox($item['id']);
    $id                 = HTML::highLight($item['id'], $searchValue);
    $username           = HTML::highLight($item['username'], $searchValue);
    $fullname           = HTML::highLight($item['fullname'], $searchValue);
    $email              = HTML::highLight($item['email'], $searchValue);
    $infoUser           = HTML::showInfoUserBuyItem($item['fullname'], $item['address'], $item['email'], $item['phone']);
    $selectBoxStatus    = HTML::createSelectBox(null, "select-status", "custom-select custom-select-sm", "width: unset", $item['id'], $item['id'], $item['status']);
    $linkStatus         = URL::createLink($moduleName, $controllerName, 'changeStatus', ['id' => $item['id'], 'status' => $item['status']]);
    $created            = Helper::formatDate(DATETIME_FORMAT, $item['date']);

    $viewLink           = URL::createLink('backend', 'cart', 'view', ['id' => $item['id']]);


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
            '.$selectBoxStatus.'
        </td>
        <td class="text-center position-relative">
            '.$detail.'
        </td>
        <td class="text-center">
            '.HTML::formatCurrency($totalPrice).'
        </td>
        <td class="text-center">
            '.$created.'
        </td>
        <td class="text-center">
            <a href="'.$viewLink.'" class="rounded-circle btn btn-sm btn-info" title="View">
                <i class="fas fa-view-alt"></i>
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