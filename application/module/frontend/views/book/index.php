<?php echo HTML::pageHeaderContentFrontend('Tất cả sách'); ?>

<section class="section-b-space j-box ratio_asos">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 collection-filter">
                    <!-- side-bar colleps block stat -->
                    <div class="collection-filter-block">
                        <!-- brand filter start -->
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                        <?php require_once 'element/sidebar/category_list.php'; ?>
                    </div>

                    <?php require_once 'element/sidebar/product_special.php'; ?>
                    <!-- silde-bar colleps block end here -->
                </div>
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="collection-product-wrapper">

                                    <?php include_once 'element/sort_filter.php'; ?>
                                    <?php require_once 'element/product.php'; ?>
                                    <?php include_once 'element/pagination.php'; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'element/quickview.php'; ?>