<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Carousel</span>

</nav>

<div class="content clearfix">

    <div class="main-content">
<input type="hidden" name="_token" value="<?php Lib_TokenService::_token('delete_carousel'); ?>" >
        <?php foreach ($carousel_images as $carousel):?>
            <article class="carousel" data-carousel_id="<?php echo $carousel['id']; ?>">

                <img  src="<?php echo URL.'uploads/carousel/'.$carousel['image']; ?>"</div>
                <p><?php echo $carousel['url']; ?></p>
            </article>


        <?php endforeach; ?>

    </div>

</div>