<?php
$linkMoreGroup      = URL::createLink('backend', 'group', 'index');
$linkMoreUser       = URL::createLink('backend', 'user', 'index');
$linkMoreCategory   = URL::createLink('backend', 'category', 'index');
$linkMoreBook       = URL::createLink('backend', 'book', 'index');
$linkMoreSlider     = URL::createLink('backend', 'slider', 'index');
$linkMoreCart       = URL::createLink('backend', 'cart', 'index');

$dashboardGroup     = HTML::createDashboard("Group", $this->countGroup, $linkMoreGroup, "bg-info");
$dashboardUser      = HTML::createDashboard("User", $this->countUser, $linkMoreUser, "bg-yellow", "ion-ios-person");
$dashboardCategory  = HTML::createDashboard("Category", $this->countCategory, $linkMoreCategory, "bg-red", "ion-clipboard");
$dashboardBook      = HTML::createDashboard("Book", $this->countBook, $linkMoreBook, "bg-blue", "ion-ios-book");
$dashboardSlider    = HTML::createDashboard("Slider", $this->countSlider, $linkMoreSlider, "bg-pink", "ion-ios-book");
$dashboardCart      = HTML::createDashboard("Cart", $this->countCart, $linkMoreCart, "bg-green", "ion-ios-cart");
?>
<div class="row justify-content-center">
<?= $dashboardGroup . $dashboardUser . $dashboardCategory . $dashboardBook . $dashboardSlider . $dashboardCart ?>
    
</div>