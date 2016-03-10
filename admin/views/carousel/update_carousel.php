<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/carousel">Carousel</a> / <span>Update carousel</span>

</nav>

<h2>Update Carousel</h2>


<div class="content clearfix">

    <div class="main-content">
        <h4> Update image</h4>
        <section id="<?php echo (int)$_GET['id']; ?>" class="image_area edit_images clearfix <?php if(isset($error['carousel_image'])) echo "error"; ?>">
            <input type="hidden" name="image_token"  value="<?php Lib_TokenService::_token('upload_image') ?>" data-handle="carousel" >
            <?php include PATH_SITE.'/admin/views/partials/image_upload.php'; ?>


            <?php if(isset($error['slider_image'])) { ?>
                <small class="red image_error"><?php echo $error['slider_image']; ?></small>
            <?php  } ?>

            <script src="/admin/assets/uploadimage.js"></script>

        </section>
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