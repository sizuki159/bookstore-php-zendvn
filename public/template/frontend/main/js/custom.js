// var searchParams = new URLSearchParams(window.location.search);

searchParams        = JSON.parse(searchParams)
var moduleName      = searchParams.module;
var controllerName  = searchParams.controller;
var actionName      = searchParams.action;

$(document).ready(function(){

    $('.btn-add-to-cart').click(function(e){
        e.preventDefault();
        var bookID      = searchParams.id;
        if(bookID == null)
            bookID = $('div.product-buttons a.btn-add-to-cart').attr('data-id')
    
        var numberItem  = $('input[name="quantity"]').val();
        if(numberItem > 0)
        {
            let linkBuy = ROOT_URL + 'index.php?module='+moduleName+'&controller=user&action=order&book_id='+bookID+'&quantity='+numberItem
            window.location.href = linkBuy
        }
    })

    $('.btn-add-to-cart-quickview').click(function(e){
        e.preventDefault();
        var bookID      = $('div.product-buttons a.btn-add-to-cart-quickview').attr('data-id')
    
        var numberItem  = $('input[name="quantity"]').val();
        if(numberItem > 0)
        {
            let linkBuy = ROOT_URL + 'index.php?module='+moduleName+'&controller=user&action=order&book_id='+bookID+'&quantity='+numberItem
            window.location.href = linkBuy
        }
    })

    if(controllerName == 'user')
    {
        $('ul#menu-account li').removeClass();
        if(actionName == 'profile')
        {
            $('ul#menu-account li#account-info').addClass('active');
        }
        else if(actionName == 'changePass')
        {
            $('ul#menu-account li#account-change-pass').addClass('active');
        }
        else if(actionName == 'orderHistory')
        {
            $('ul#menu-account li#account-history-order').addClass('active');
        }
    }

    
})

function quickView(id)
{
    var linkAction = ROOT_URL + 'index.php?module='+moduleName+'&controller=' + controllerName + '&action=quickView&id=' + id
    $.get(linkAction, function(data){
        console.log(data)
        $('h2.book-name').html(data.name)
        $('h3.book-price').html(data.price_format)
        $('div.book-description').html(data.description)
        $('div.quick-view-img img').attr('src', data.picture)
        $('div.product-buttons a.btn-add-to-cart').attr('href', data.linkBuy)
        $('div.product-buttons a.btn-add-to-cart').attr('data-id', data.id)
        $('div.product-buttons a.btn-add-to-cart-quickview').attr('href', data.linkBuy)
        $('div.product-buttons a.btn-add-to-cart-quickview').attr('data-id', data.id)
        $('div.product-buttons a.btn-view-book-detail').attr('href', data.linkDetail)
    }, 'json')
}