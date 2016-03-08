<div class="content-header">

    <a href="<?php echo $_SESSION['history_back']; ?>" class="left button">Назад</a>

   <h2>Add new product</h2>

</div>

<input type="hidden" name="_token" id="load_image" value="<?php Lib_TokenService::_token('upload_image') ?>" >

<?php include PATH_SITE.'/admin/views/partials/images.php'; ?>


<div class="product_form">

        <form action="/admin/product/store" method="POST">
            <input type="hidden" name="_token" id="create_product_token" value="<?php Lib_TokenService::_token('add_product') ?>" >

            <?php include PATH_SITE.'/admin/views/partials/product_area.php'; ?>

            <input type="submit" id="sub_created" value="Add product" >


        </form>

</div>
