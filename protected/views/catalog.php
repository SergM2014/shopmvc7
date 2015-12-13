<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>">Головна</a> / <span>Каталог</span>

</nav>

<div class="the_content clearfix">

    <section class="anotherleftmenu left">

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

        <form action="/catalog/index" id="reset_all">
            <button>Сбросить все фильтры</button>
        </form>

    <?php if(!empty($catalog)) : ?>



    <form  method="GET" action="/catalog/index">

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

        <?php foreach($catalog as $good): ?>
            <article class="good">



                <?php if(isset($good['images'])): ?>

                    <div class="images">
                        <?php echo $good['images']; ?>
                    </div>
                <?php endif; ?>
                    <h2><strong><?php echo $good['product_title']; ?></strong></h2>
                    <h3> <?php echo $good['author']; ?></h3>
                    <br>
                    <h3><?php echo $good['description']; ?></h3>

                    <?php if($good['translit_title']) { ?><p>Категория: <b><?php echo $good['translit_title']; ?></b></p><?php } ?>
                    <?php if($good['manufacturer_title']) { ?><p>Производитель: <b><?php echo $good['manufacturer_title']; ?></b></p><?php } ?>
                    <h3><strong><?php echo $good['price']; ?> грн.</strong></h3>
                    <a href="/product/index?id=<?php echo $good['product_id']; ?>" id="detail" class="right">Подробнее</a>
            </article>


        <?php endforeach; ?>

            <?php if($pages>1): ?>

            <nav class="pagination">

                <?php
                $current = (isset($_GET['p']))? $_GET['p']: 1;

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




