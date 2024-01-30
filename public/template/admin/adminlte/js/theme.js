$(document).ready(function () {
    var searchParams = new URLSearchParams(window.location.search);
    var moduleName = searchParams.get('module');
    var controllerName = searchParams.get('controller');

    $('.btn-random-string').click(function (e) {
        e.preventDefault()
        var newString = randomString()
        $('#password').val(newString);
    })

    $('.btn-delete-item').click(function (e) {
        e.preventDefault();
        var linkDelete = $(this).attr('href')
        Swal.fire({
            title: 'Bạn có chắc?',
            text: "Bạn có chắc chắn muốn xóa!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value){
                window.location.href = linkDelete;
            }
        })
    })

    // Change group event
    $('[name="select-group"]').change(function () {
        $currentSelectGroup = $(this);
        let groupId = $(this).val();
        let userId = $(this).data('id');
        console.log(userId)
        let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxChangeGroup&id=${userId}&group_id=${groupId}`;
        $.get(
            url,
            function (data) {
                $('.modified-' + data.id).html(data.modified);
                showNotify($currentSelectGroup, 'success-update');
            },
            'json'
        );
    });

    // Change ordering event
    $('.chkOrdering').change(function () {
        $chkOrdering = $(this);
        let ordering = $(this).val();
        let userId = $(this).data('id');
        let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxOrdering&id=${userId}&ordering=${ordering}`;

        $.get(url, function (data) {
                console.log(data)
                $('.modified-' + data.id).html(data.modified);
                showNotify($chkOrdering, 'success-update');
        }, 'json');
    });

    // Change category event
    $('[name="select-category"]').change(function () {
        $currentSelectCategory = $(this);
        let categoryId = $(this).val();
        let userId = $(this).data('id');
        let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxChangeCategory&id=${userId}&category_id=${categoryId}`;
        $.get(
            url,
            function (data) {
                $('.modified-' + data.id).html(data.modified);
                showNotify($currentSelectCategory, 'success-update');
            },
            'json'
        );
    });

    $('#filter-bar select[name=filter_group_acp]').change(function () {
        $('#filter-bar').submit();
    });

    $('#filter-bar select[name=filter_group_id]').change(function () {
        $('#filter-bar').submit();
    });

    $('#filter-bar select[name=filter_category_id]').change(function () {
        $('#filter-bar').submit();
    });

    $('#btn-clear-search').click(function () {
        $('input[name=search]').val('');
    });

    $('[name="select-group"]').change(function () {
        $currentSelectGroup = $(this);
        let groupId = $(this).val();
        let userId = $(this).data('id');
        let url = `index.php?module=${moduleName}&controller=${controllerName}&action=ajaxChangeGroup&id=${userId}&group_id=${groupId}`;
        $.get(
            url,
            function (data) {
                console.log(data);
                $('.modified-' + data.id).html(data.modified);
                showNotify($currentSelectGroup, 'success-update');
            },
            'json'
        );
    });

    $('.my-btn-ajax').click(function (e) {
        e.preventDefault();
        $myBtnState = $(this);
        var url = $(this).attr('href');
        $.get(
            url,
            function (data) {
                if (data.state == 1 || data.state == 'active') {
                    $myBtnState.removeClass('btn-danger');
                    $myBtnState.addClass('btn-success');
                    $myBtnState.find('i').attr('class', 'fas fa-check');
                } else {
                    $myBtnState.removeClass('btn-success');
                    $myBtnState.addClass('btn-danger');
                    $myBtnState.find('i').attr('class', 'fas fa-minus');
                }
                $('.modified-' + data.id).html(data.modified);
                $myBtnState.attr('href', data.link);
                showNotify($myBtnState, 'success-update');
            },
            'json'
        );
    });

    $('#btn-search').click(function (e) {
        var btnCurrent = $(this);
        if($('input[name=search]').val() == '')
        {
            e.preventDefault();
            btnCurrent.notify(
                "Nhập dữ liệu trước khi search", {
                    position: "top-right",
                    className: "warn"
                }
            );
        }
    });

    $('input[id=check-all]').change(function () {
        var checkStatus = this.checked;
        $('#form-table').find('input[name="checkbox[]"]').each(function () {
            this.checked = checkStatus;
        })
        showSelectedRowInBulkAction();
    })

    $('#form-table input[name="checkbox[]"]').change(function () {
        showSelectedRowInBulkAction();
    });

    $('#bulk-apply').click(function () {
        var action = $('#bulk-action').val();
        var link = 'index.php?module=' + moduleName + '&controller=' + controllerName + '&action=';
        var countCheckInput = $('[name="checkbox[]"]:checked').length

        switch (action) {
            case 'multi-active':
                link += 'active';
                break;
            case 'multi-inactive':
                link += 'inactive';
                break;
            case 'multi-delete':
                link += 'delete';
                break;
            default:
                $(this).notify(
                    "Vui lòng chọn action", {
                        position: "top-center",
                        className: "warn"
                    }
                );
                returnToPreviousPage();
                break;
        }
        checkCountInput(countCheckInput)

        Swal.fire({
            title: 'Bạn có chắc?',
            text: "Bạn có chắc chắn thực hiện hành động này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, I sure!'
        }).then((result) => {
            if (result.value){
                $('#form-table').attr('action', link);
                $('#form-table').submit();
            }
        })

    });

    setTimeout(function () {
        $('#admin-message').fadeOut('slow');
    }, 4000);
});


function checkCountInput(countCheckInput) {

    if (countCheckInput <= 0) {
        $("#bulk-apply").notify(
            "Chọn ít nhất 1 ô dữ liệu", {
                position: "top-center",
                className: "warn"
            }
        );
        returnToPreviousPage();
    }
}

function submitForm(link) {
    $('#admin-form').attr('action', link);
    $('#admin-form').submit();
}

function randomString() {
    var stringRandom = Math.random().toString(36).slice(-10);
    return stringRandom;
}

function showSelectedRowInBulkAction() {
    let checkbox = $('#form-table input[name="checkbox[]"]:checked');
    let navbarBadge = $('#bulk-apply .navbar-badge');
    if (checkbox.length > 0) {
        navbarBadge.html(checkbox.length);
        navbarBadge.css('display', 'inline');
    } else {
        navbarBadge.html('');
        navbarBadge.css('display', 'none');
    }
}

function showNotify($element, $type = 'success-update') {
    switch ($type) {
        case 'success-update':
            $element.notify('Cập nhật thành công!', {
                className: 'success',
                position: 'top center',
            });
            break;
    }
}