<nav class="breadcrumbs">

    <span>Головна</span>

</nav>


<section class="leftmenu left"><!--! клас лефтменю не трогать-->

    <h3>Рубрики</h3>

    <ul id="leftmenu"><?php echo $menu; ?></ul>

</section>

<section class="slider-content right">


    <!-- realization of slider-->
    <link rel="stylesheet" href="/lib/jqueryfreeslider/style.css">

    <?php $num=1; if(!empty($sliders)): ?>
        <div id="slider">
            <?php foreach($sliders as $image): ?>
                <div class="thumb" style="display:none; background: url(<?php echo '/uploads/slider/'.$image['image']; ?>) no-repeat center top;" id="<?php echo $num;?>">

                    <div class="bottom">
                        <a href="/<?php echo $image['url']; ?>">
                            Надпись яка йде внызу
                        </a>
                    </div>

                </div><!-- thumb -->
                <?php $num++; endforeach; ?>
        </div>
    <?php endif; ?>
    <!-- end of realization of slider-->


    <script src="/lib/jqueryfreeslider/script.js"></script>

</section>

<div class="clearfix"></div>




<link rel="stylesheet" href="/lib/jqueryfreecarousel/style.css">

<div id="scroller_container" >
    <div>
        <?php
        foreach($carousel as $image){
            ?> <a href="<?php echo $image['url']; ?>"><img src="<?php echo URL.'uploads/carousel/'.$image['image']; ?>"></a>
        <?php    } ?>

    </div>
</div>

<script src="/lib/jqueryfreecarousel/script.js"></script>