<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/slider">Slider</a> / <span>Add slider</span>

</nav>

<div class="content clearfix">

    <div class="main-content">
        <h2>Add Slider</h2>
        <section  class="image_area edit_images clearfix <?php if(isset($error['slider_image'])) echo "error"; ?>">
            <input type="hidden" name="image_token"  value="<?php Lib_TokenService::_token('upload_image') ?>" data-handle="slider" >
        <?php include PATH_SITE.'/admin/views/partials/image_upload.php'; ?>


            <?php if(isset($error['slider_image'])) { ?>
                <small class="red image_error"><?php echo $error['slider_image']; ?></small>
            <?php  } ?>

            <script src="/admin/assets/uploadimage.js"></script>

        </section>




        <section class="slider_input">
            <form action="/admin/slider/store" method="POST">
                <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('create_new_slider') ?>"
                <p> <input type="text" name="slider_url" value="<?php if(isset($slider_url)) echo $slider_url; ?>" <?php if(isset($error['slider_url'])) echo 'class="error"'; ?> placeholder="enter slider url">
                    <?php if(isset($error['slider_url'])): ?><small class="red"><?php echo $error['slider_url']; ?></small> <?php endif; ?></p>
                <br>
                <p><input type="submit" value="create slider"></p>
            </form>
        </section>


    </div>

</div>