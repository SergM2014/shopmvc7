<section  class="edit_images">
    <?php if(isset($images) AND is_array($images)) : ?>
<?php var_dump($images); ?>
        <?php foreach ($images as $key=>$image): ?>
            <div id="<?php echo $key; ?>" class="image_area">
                <?php include PATH_SITE.'/admin/views/productImageUpload.php'; ?>

            </div>
        <?php endforeach; ?>

        <?php unset($image); endif; ?>
    <div id="<?php echo time().'_'.mt_rand(1000, 9999); ?>" class="image_area">
        <?php include PATH_SITE.'/admin/views/productImageUpload.php'; ?>
    </div>
</section>

<script src="/admin/assets/uploadimage.js"></script>