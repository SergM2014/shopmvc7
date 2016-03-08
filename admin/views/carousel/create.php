<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/carousel">Carousel</a> / <span>Add carousel</span>

</nav>
<h2>Add Carousel</h2>
<h4> Add image</h4>

<div class="content clearfix">

    <div class="main-content">
        <?php include 'upload_carousel.php'; ?>

        <section class="carousel_input">
            <form action="/admin/carousel/store" method="POST">

                <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('create_new_carousel') ?>">


                <p> <input type="text" name="carousel_url" value="<?php if(isset($carousel_url)) echo $carousel_url; ?>" <?php if(isset($error['carousel_url'])) echo 'class="error"'; ?> placeholder="enter carousel url">
                    <?php if(isset($error['carousel_url'])): ?><small class="red"><?php echo $error['carousel_url']; ?></small> <?php endif; ?></p>
                <br>
                <p><input type="submit" value="Create carousel"></p>
            </form>
        </section>


    </div>

</div>