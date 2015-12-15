
<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>">Головна</a> / <a href="<?php echo URL; ?>catalog ">Каталог</a> / <span>продукт</span>

</nav>

<div class="the_content clearfix">

    <article class="in_details">
        <h2 class="message"><?php echo $product['title']; ?></h2>
        <p><b>Автор:</b>  <?php echo $product['author']; ?></p><br>
        <p><b>Описание:</b> <?php echo $product['description']; ?></p><br>
        <p><b>Отрывок:</b> <?php echo $product['body']; ?></p><br>
        <?php if (isset($product['cat_title'])) echo '<p> <b>Категория:</b> '.$product['cat_title'].'</p><br>'; ?>
        <?php if (isset($product['manf_title'])) echo '<p> <b>Производитель:</b> '.$product['manf_title'].'</p><br>'; ?>
        <p class="red"><b>Цена:</b> <span id="the_price"><?php echo $product['price']; ?></span> грн</p>
        <button  id="add_item" item="<?php echo $_GET['id']; ?>" class="right" _token="<?php echo AppUser::_token(); ?>">  Купить  </button>
    </article>

</div>