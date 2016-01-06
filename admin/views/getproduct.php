<p>That s the product view page</p>
<h2>Product number <?php echo $product['product_id']; ?></h2>
<div class="edit_form">

    <form>
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>"
        <p><h4>Название: </h4>
            <input type="text" name="title" value="<?php echo $product['product_title'] ?>"></p>
        <br>
       <p><h4>Автор: </h4>
           <input type="text" name="author" value="<?php echo $product['author']; ?>" ></p>
        <br>
        <p><h4>Описание: </h4>
            <textarea id="description" name="description" cols="35" rows="5"><?php echo $product['description'] ?></textarea> </p>
        <br>
        <p><h4>Отрывок: </h4>
            <textarea id="body" name="body" cols="35" rows="5"><?php echo $product['body'] ?></textarea> </p>
        </br>
        <p><h4>Цена: </h4>
            <input type="text" name="price" value="<?php echo $product['price']; ?>"></p>
        <br>
        <p><h4>Выберите категорию: </h4>
            <?php echo $categories_tree; ?></p>
        <br>
        <p><h4>Выберите производителя: </h4>
        <div class="styled-select">
            <select size="1" name ="manufacturer" >

                <?php foreach ($manufacturers as $manf): ?>
                <option <?php if($product['manufacturer_id']== $manf['id']) echo "selected"; ?> value="<?php echo $manf['id']; ?>"> <?php echo $manf['title']; ?></option>
                <?php endforeach; ?>

            </select>
        </div>
        </p>
        <br>
        <p><input type="submit" id="sub_edited" value="Aplay changes" ></p>

    </form>

</div>
