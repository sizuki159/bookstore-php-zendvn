
<?php echo HTML::pageHeaderContentFrontend($this->infoBook['name']); ?>

<section class="section-b-space">
    <div class="collection-wrapper">
        <div class="container">
            
            <div class="row">
                <?php echo HTML::showDetailProductFrontend($this->infoBook) ?>

                <div class="col-sm-3 collection-filter">
                    <div class="collection-filter-block">
                        <div class="collection-mobile-back">
                            <span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span>
                        </div>
                        <?php include_once 'element/product_service.php'; ?>
                    </div>

                    <?php include_once 'element/sidebar/product_special.php'; ?>
                    <?php include_once 'element/sidebar/product_new.php'; ?>
                    
                </div>
            </div>

            <?php include_once 'element/product_relative.php'; ?>
            
        </div>
    </div>
</section>

<?php require_once 'element/quickview.php'; ?>
