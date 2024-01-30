<?php
$linkReload = URL::createLink($moduleName, $controllerName, $actionName);
$linkAddNew = URL::createLink($moduleName, $controllerName, 'form');
?>

<div class="card card-info card-outline">
    <div class="card-header">
        <h4 class="card-title">List</h4>
        <div class="card-tools">
            <a href="<?= $linkReload ?>" class="btn btn-tool"><i class="fas fa-sync"></i></a>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">

        <!-- List Content -->
        <form action="" method="post" class="table-responsive" id="form-table">
            <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="check-all">
                                <label for="check-all" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="text-center">Mã đơn hàng</th>
                        <th class="text-center">Thông tin</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Chi tiết</th>
                        <th class="text-center">Tổng tiền</th>
                        <th class="text-center">Ngày đặt</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $xhtml; ?>
                </tbody>
            </table>
        </form>
    </div>
    <div class="card-footer clearfix">
        <?= $this->pagination->showPaginationAdmin(); ?>
    </div>
</div>