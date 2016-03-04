<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Categories</span>

</nav>

<div class="content clearfix">

    <div class="main-content">
<input type="hidden" name="_token" value="<?php Lib_TokenService::_token('delete_slider'); ?>" >
        <?php foreach ($sliders as $slider) :?>
            <article class="slider" data-slider_id="<?php echo $slider['id']; ?>">

                <img  src="<?php echo URL.'uploads/slider/'.$slider['image']; ?>">
                <div class="slider-url"><?php echo $slider['url']; ?></div>
            </article>


        <?php endforeach; ?>

    </div>

</div>