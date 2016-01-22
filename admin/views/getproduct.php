<h2>Product number <?php echo $product['product_id']; ?></h2>



<section  class="edit_images">
    <?php if($images) : ?>

    <?php foreach ($images as $key=>$image): ?>
             <div id="<?php echo $key; ?>" class="image_area">
                <?php include PATH_SITE.'/admin/views/productImageUpload.php'; ?>

             </div>
        <?php endforeach; ?>

    <?php unset($image); endif; ?>
    <div id="<?php echo time().'_'.mt_rand(1, 1000); ?>" class="image_area">
        <?php include PATH_SITE.'/admin/views/productImageUpload.php'; ?>
    </div>
</section>

<script src="/admin/assets/uploadimage.js"></script>


<div class="edit_form">

    <form action="/admin/product/updateProduct" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
        <p><h4>Название: </h4>
            <input type="text" name="title" <?php if (isset($error['title'])) echo 'class="error"'; ?> value="<?php echo isset($product['title'])? $product['title']:''; ?>"   maxlength="120">
        <?php if (isset($error['title'])) echo '<small class="red">'.$error['title'].'</small>'; ?>
        </p>
        <br>
       <p><h4>Автор: </h4>
           <input type="text" name="author" <?php if (isset($error['author'])) echo 'class="error"'; ?> value="<?php echo isset($product['author'])? $product['author']: ''; ?>"  maxlength="120">
        <?php if (isset($error['author'])) echo '<small class="red">'.$error['author'].'</small>'; ?>
        </p>
        <br>
        <small> в ОПИСАНИИ И ОТРЫВКЕ можна исполбзовать следущие теги:
            &lt;a&gt; &lt;b&gt; &lt;blockquote&gt; &lt;br&gt; &lt;button&gt; &lt;cite&gt; &lt;code&gt; &lt;div&gt;
            &lt;dd&gt; &lt;dl&gt; &lt;dt&gt; &lt;em&gt; &lt;fieldset&gt;&lt;font&gt; &lt;h1&gt; &lt;h2&gt; &lt;h3 &gt;
            &lt;h4&gt; &lt;h5&gt; &lt;hr&gt; &lt;i&gt; &lt;it&gt; &lt;img&gt; &lt;label&gt; &lt;li&gt; &lt;ol&gt;
            &lt;p&gt; &lt;pre&gt; &lt;span&gt;&lt;strong&gt; &lt;table&gt; &lt;tbody&gt; &lt;tr&gt; &lt;td&gt;
            &lt;th&gt; &lt;ul&gt; </small>
        <p><h4>Описание: </h4>
            <textarea id="description" name="description" cols="35" rows="5"
                <?php if (isset($error['description'])) echo 'class="error"'; ?> ><?php echo isset($product['description'])? $product['description']: ''; ?></textarea>
        <?php if (isset($error['description']))
            echo '<small class="red">'.$error['description'].'</small>'; ?></p>
        <br>
        <p><h4>Отрывок: </h4>
            <textarea id="body" name="body" cols="35" rows="5" <?php if (isset($error['body'])) echo 'class="error"'; ?> ><?php echo isset($product['body'])? $product['body']: ''; ?></textarea>
         <?php if (isset($error['body'])) echo '<small class="red">'.$error['body'].'</small>'; ?> </p>
        </br>
        <p><h4>Цена: </h4>
            <input type="text" name="price" <?php if (isset($error['price'])) echo 'class="error"'; ?> value="<?php echo isset($product['price'])? $product['price']: ''; ?>"  >
        <?php if (isset($error['price'])) echo '<small class="red">'.$error['price'].'</small>'; ?>
        </p>
        <br>
        <p><h4>Выберите категорию: </h4>

        <div class="styled-select">
            <?php echo $categories_tree; ?></p>
        </div>
        <br>
        <p><h4>Выберите производителя: </h4>
        <div class="styled-select">
            <select size="1" name ="manufacturer_id" >
                <option value="">Без производителя</option>
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
