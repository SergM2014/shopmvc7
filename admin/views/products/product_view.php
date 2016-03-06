<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/product/index">Список продуктов</a> / <span>Product</span>

</nav>

<div class="product_content clearfix">

    <input type="button" onclick="history.back();" value="Назад" class="menu_button">

    <?php if($product['images']) : ?>
        <div class="images_preview_area clearfix">

            <?php  foreach($product['images'] as $image ) : ?>
                <img src="/uploads/product_images/<?php echo $image; ?>" class="preview_image">

            <?php endforeach; ?>
        </div>
    <?php endif; ?>




    <article class="in_details">
        <h2 class="message"><?php echo $product['title']; ?></h2>
        <p><b>Автор:</b>  <?php echo $product['author']; ?></p><br>
        <p><b>Описание:</b> <?php echo $product['description']; ?></p><br>
        <p><b>Отрывок:</b> <?php echo $product['body']; ?></p><br>
        <?php if (isset($product['category_title'])) echo '<p> <b>Категория:</b> '.$product['category_translit_title'].'</p><br>'; ?>
        <?php if (isset($product['manufacturer_title'])) echo '<p> <b>Производитель:</b> '.$product['manufacturer_title'].'</p><br>'; ?>
        <p class="red"><b>Цена:</b> <span id="the_price"><?php echo $product['price']; ?></span> грн</p>

    </article>

</div>
