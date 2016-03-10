<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/carousel">Carousel</a> / <span>Add carousel</span>

</nav>
<h2>Add Carousel</h2>
<h4> Add image</h4>

<div class="content clearfix">

    <div class="main-content">
        <section  class="image_area edit_images clearfix <?php if(isset($error['carousel_image'])) echo "error"; ?>">
            <input type="hidden" name="image_token"  value="<?php Lib_TokenService::_token('upload_image') ?>" data-handle="carousel" >
            <?php include PATH_SITE.'/admin/views/partials/image_upload.php'; ?>


            <?php if(isset($error['carousel_image'])) { ?>
                <small class="red image_error"><?php echo $error['carousel_image']; ?></small>
            <?php  } ?>

            <script src="/admin/assets/uploadimage.js"></script>

        </section>

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