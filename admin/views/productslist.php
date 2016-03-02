
<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Каталог</span>

</nav>

<div class="content clearfix">

    <section class="leftmenu left">

        <div class="catalog-menu">
            <h3>Рубрики</h3>

            <ul><?php echo $menu; ?></ul>
        </div>

        <div class="catalog-menu">
            <h3>Производители</h3>
            <ul>
                <?php foreach ($manufacturers as $manf) : ?>
                    <li><a href="<?php echo URL.$nomanufacturer.'manufacturer='.$manf['title']; ?>"><?php echo $manf['title']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </section>

    <section class="main-content right">


        <div class="content-header-width"><a href="/admin/product/create" class="menu_button">+ Add Item</a></div>

        <form action="/admin/product/index" id="reset_all" class="right">
            <button>Сбросить все фильтры</button>
        </form>

        <?php if(!empty($catalog)) : ?>


        <form  method="GET" action="/admin/product/lists">

            <?php if (isset($_GET['category'])) { ?> <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>" > <?php }
            if(isset($_GET['manufacturer'])) { ?> <input type="hidden" name="manufacturer" value="<?php echo $_GET['manufacturer']; ?>" > <?php } ?>

            <label for="select">Сортировать по: </label>
            <select size="1" name="order" id="select">
                <option value="default"></option>
                <option value="abc">а-я</option>
                <option value="cba">я-а</option>
                <option value="cheap_first">сначала дешевые</option>
                <option value="expensive_first">сначала дорогие</option>
            </select>

            <input type="submit" value="OK">
        </form>


        <div class="articles_good">

            <table>
                <tr><th>№</th><th>Picture</th><th>Author</th><th>Title</th><th>Category</th><th>Manufacturer</th><th>Description</th><th>Price</th></tr>
                 <?php foreach($catalog as $one): ?>

                <tr data-product_id="<?php echo $one['product_id']; ?>">
                    <td ><?php echo $one['number']; ?></td>
                    <td><?php if(!empty($one['images'])){   ?> <img src="/uploads/product_images/thumbs/<?php echo $one['images'][0]; ?>" > <?php } ?></td>
                    <td><?php echo $one['author']; ?></td>
                    <td><?php echo $one['product_title']; ?></td>
                    <td><?php echo $one['translit_title']; ?></td>
                    <td><?php echo $one['manufacturer_title']; ?></td>
                    <td><?php echo $one['description']; ?></td>
                    <td><?php echo $one['price']; ?></td>
                </tr>

                 <?php endforeach; ?>

            </table>

        </div>

            <?php if($pages>1): ?>

                <nav class="pagination">

                    <?php
                    $current =(isset($_GET['p']))? $_GET['p']: 1;

                    for($i =0; $i<$pages; $i++): ?>

                        <?php if($i==0 && $current>1){ ?>  <a href="<?php echo URL.$nop.'p=1' ?>"> << </a> <?php } ?>
                        <?php if($i == 0 && $pages>1 && $current>1) {  ?> <a href="<?php echo URL.$nop.'p='.($current-1) ?>"> < </a>  ... <?php } ?>
                        <?php

                        if($i> ($current-6) && $i<($current+4)): ?>

                            <a href="<?php echo URL.$nop.'p='.($i+1); ?>"><?php if($i+1==$current){echo '<b>'.($i+1).'</b>'; } else { echo ($i+1);} ?></a>

                        <?php endif; ?>
                        <?php if($current<$pages): ?>
                            <?php if($i == $pages-1 && $pages>1 && $current<$pages) {  ?>...  <a href="<?php echo URL.$nop.'p='.($current+1) ?>"> > </a> <?php } ?>
                            <?php if($i==$pages-1){ ?>  <a href="<?php echo URL.$nop.'p='.$pages ?>"> >> </a> <?php } ?>
                        <?php endif; ?>


                    <?php endfor; ?>
                </nav>

            <?php endif; ?>
        <?php else: ?>
            <h2 class="message">Nothing is found!</h2>
            <p class="message">Try another query</p>
        <?php endif; ?>
    </section><!--/main content right -->

</div>
