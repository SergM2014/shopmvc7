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
            <option <?php if(isset($product['manufacturer_id']) && $product['manufacturer_id']== $manf['id']) echo "selected"; ?> value="<?php echo $manf['id']; ?>"> <?php echo $manf['title']; ?></option>
        <?php endforeach; ?>

    </select>
</div>
</p>
<br>