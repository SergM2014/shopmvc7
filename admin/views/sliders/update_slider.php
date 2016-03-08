<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/slider">Slider</a> / <span>Add slider</span>

</nav>

<div class="content clearfix">

    <div class="main-content">
        <?php include 'upload_slider.php'; ?>

        <section class="slider_input">
            <form action="/admin/slider/update" method="POST">

                <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('update_slider') ?>">
                <input type="hidden" name="id" value="<?php echo $slider_id; ?>" >

                <p> <input type="text" name="slider_url" value="<?php if(isset($slider_url)) echo $slider_url; ?>" <?php if(isset($error['slider_url'])) echo 'class="error"'; ?> placeholder="enter slider url">
                    <?php if(isset($error['slider_url'])): ?><small class="red"><?php echo $error['slider_url']; ?></small> <?php endif; ?></p>
                <br>
                <p><input type="submit" value="Update slider"></p>
            </form>
        </section>


    </div>

</div>