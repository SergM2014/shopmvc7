<div class="content-header">

    <a href="<?php echo $_SESSION['history_back']; ?>" class="left button">Назад</a>

    <h2>Edit product number <?php echo $product['product_id']; ?></h2>

</div>


<?php include 'partials/images.php'; ?>



<div class="product_form">

    <form action="/admin/product/update" method="POST">

        <input type="hidden" name="_token" id="update_product_token" value="<?php echo AppUser::_token('update_product') ?>" >
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <?php include 'partials/product_area.php'; ?>

        <input type="submit" id="sub_edited" value="Update product" >

    </form>

</div>