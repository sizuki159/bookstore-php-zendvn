<?php
$xhtml = '';
if(!empty($this->slider))
{
    foreach($this->slider as $slider)
    {
        $linkImg = UPLOAD_URL . 'slider' . DS . $slider['picture'];
        $xhtml .= '
        <div>
            <a href="'.$slider['link'].'" class="home text-center">
                <img src="'.$linkImg.'" alt="" class="bg-img blur-up lazyload">
            </a>
        </div>
        ';
    }
}

?>
<section class="p-0 my-home-slider">
    <div class="slide-1 home-slider">
        <?php echo $xhtml; ?>
    </div>
</section>