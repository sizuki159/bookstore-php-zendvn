<?php
$inputHiddenModule = '<input type="hidden" name="module" value="' . $moduleName . '">';
$inputHiddenController = '<input type="hidden" name="controller" value="' . $controllerName . '">';
$inputHiddenAction = '<input type="hidden" name="action" value="' . $actionName . '">';

array_unshift($this->listItemCategory, ['name' => '- Select Category -', 'id' => 'default']);
$slbFilterCategoryName = HTML::createSelectBox($this->listItemCategory, "filter_category_id", "custom-select custom-select-sm mr-1", "width: unset", "filter_category", null, $this->arrParam['filter_category_id']);

$itemsStatusCount = [
    'all' => $this->countActive + $this->countInactive,
    'active' => $this->countActive,
    'inactive' => $this->countInactive
];

$currentFilterStatus = $this->arrParam['status'] ?? 'all';
$xhtmlFilterButton = HTML::showFilterButton($moduleName, $controllerName, $itemsStatusCount, $currentFilterStatus);
?>

<div class="card card-info card-outline">
    <div class="card-header">
        <h6 class="card-title">Search & Filter</h6>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-between">
            <div class="mb-1">
                <?= $xhtmlFilterButton ?>
            </div>
            <div class="mb-1">
                <form action="" method="GET" id="filter-bar">
                    <?= $inputHiddenModule . $inputHiddenController . $inputHiddenAction ?>
                    <?= $slbFilterCategoryName ?>
                </form>
            </div>
            <div class="mb-1">
                <form action="" method="GET" id="search-form">
                    <div class="input-group">
                        <?= $inputHiddenModule . $inputHiddenController . $inputHiddenAction ?>
                        <input type="text" class="form-control form-control-sm" name="search" value="<?= $searchValue ?>" style="min-width: 300px">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-danger" id="btn-clear-search">Clear</button>
                            <button type="submit" class="btn btn-sm btn-info" id="btn-search">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>