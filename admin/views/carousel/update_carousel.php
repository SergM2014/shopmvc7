<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/carousel">Carousel</a> / <span>Update carousel</span>

</nav>

<h2>Update Carousel</h2>


<div class="content clearfix">

    <div class="main-content">
        <h4> Update image</h4>
        <?php include 'upload_carousel.php'; ?>

        <section class="carousel_input">
            <form action="/admin/carousel/update" method="POST">

                <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('update_carousel') ?>">
                <input type="hidden" name="id" value="<?php echo $carousel_id; ?>" >

                <p> <input type="text" name="carousel_url" value="<?php if(isset($carousel_url)) echo $carousel_url; ?>" <?php if(isset($error['carousel_url'])) echo 'class="error"'; ?> placeholder="enter carousel url">
                    <?php if(isset($error['carousel_url'])): ?><small class="red"><?php echo $error['carousel_url']; ?></small> <?php endif; ?></p>
                <br>
                <p><input type="submit" value="Update carousel"></p>
            </form>
        </section>


    </div>

</div>