
<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>">Головна</a> / <a href="<?php echo URL; ?>catalog ">Каталог</a> / <span>продукт</span>

</nav>

<div class="the_content clearfix">

    <article class="in_details">
        <h2 class="message"><?php echo $product['product_title']; ?></h2>
        <p><b>Автор:</b>  <?php echo $product['author']; ?></p><br>
        <p><b>Описание:</b> <?php echo $product['description']; ?></p><br>
        <p><b>Отрывок:</b> <?php echo $product['body']; ?></p><br>
        <?php if (isset($product['category_title'])) echo '<p> <b>Категория:</b> '.$product['category_translit_title'].'</p><br>'; ?>
        <?php if (isset($product['manufacturer_title'])) echo '<p> <b>Производитель:</b> '.$product['manufacturer_title'].'</p><br>'; ?>
        <p class="red"><b>Цена:</b> <span id="the_price"><?php echo $product['price']; ?></span> грн</p>
        <button  id="add_item" item="<?php echo $_GET['id']; ?>" class="right" _token="<?php echo AppUser::_token('addIntoBusket'); ?>">  Купить  </button>
    </article>

    <section class="commentsarea">
        <div class="published_comments ">

            <?php if(empty($comments)): ?>
                <h2>No comments yet. you can be first!</h2>

            <?php else: ?>

            <h2>Comments</h2>

            <form id="comments_order" data-id="<?php echo $_GET['id']; ?>">
                <p><b>Сортироват по: </b></p>
                <label><input name="comments_order" type="radio" value="new_first" checked> Сначала новые </label>
                <label><input name="comments_order" type="radio" value="old_first"> Сначала старые </label>
                <input type="hidden" id ="comments_order_token" name="comments_order_token" value="<?php echo AppUser::_token('commentsOrder'); ?>" >
            </form>
            <div id="ordered_comments"
             <?php include 'orderedComments.php'; ?>
            </div>
            <?php endif; ?>

        </div>

        <?php

        include ('commentBlock.php')  ?>

    </section>

