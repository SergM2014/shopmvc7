<p>That s the product view page</p>

<div class="edit_form">

    <form>
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>"
        <p>Название: <br>
            <input type="text" name="title" value="<?php echo $product['product_title'] ?>"></p>
       <p>Автор: <br>
           <input type="text" name="author" value="<?php echo $product['author']; ?>" ></p>

        <p>Описание: <br>
            <textarea id="description" name="description"><?php echo $product['description'] ?></textarea> </p>
        <p>Отрывок: <br>
            <textarea id="body" name="body"><?php echo $product['body'] ?></textarea> </p>
        <p>Цена: <br>
            <input type="text" name="price" value="<?php echo $product['price']; ?>"></p>
        <p>Категория: <br>
            <?php echo $categories_tree; ?></p>
        <p>Производитель: <br>
            <input type="text" name="manufacturer" value="<?php echo $product['manufacturer_title'] ?>">
        <select name ="manufacturer" >
            <option  ></option>
        </select>

        </p>


    </form>

</div>

<hr>

<?php if(empty($comments)): ?>
    <p>no comments!</p>
<?php else: ?>

    <?php var_dump($comments); ?>
<?php endif; ?>



<hr>
