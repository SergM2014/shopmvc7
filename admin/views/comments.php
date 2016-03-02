<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Comments</span>

</nav>

<div class="content clearfix">

    <div class="main-content">

        <h2>Comments edit area</h2>

        <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('general_purpose_comment') ?>" >

            <div class="select_area clearfix">
                <form  method="GET" action="/admin/comment">



                    <div class="left">
                        <label for="select">Сортировать по: </label>
                        <div class="styled-select">

                            <select size="1" name="order" id="select">
                                <!--<option value="default"></option>-->
                                <option value="title_abc" <?php Lib_HelperService::ifSelected('order', 'title_abc'); ?>>название продукта а-я</option>
                                <option value="title_cba" <?php Lib_HelperService::ifSelected('order', 'title_cba'); ?> >название продукта я-а</option>
                                <option value="name_abc" <?php Lib_HelperService::ifSelected('order', 'name_abc'); ?> >имя коментатора а-я</option>
                                <option value="name_cba" <?php Lib_HelperService::ifSelected('order', 'name_cba'); ?> >имя коментатора ф-я</option>
                                <option value="email_abc" <?php Lib_HelperService::ifSelected('order', 'email_abc'); ?> >Email а-я</option>
                                <option value="email_cba" <?php Lib_HelperService::ifSelected('order', 'email_cba'); ?> >Email z-a</option>
                                <option value="created_first" <?php Lib_HelperService::ifSelected('order', 'created_first'); ?> >сначала ранние</option>
                                <option value="created_last" <?php if(!isset($_GET['order']) OR $_GET['order']=='created_last') echo "selected"; ?> >сначала поздние</option>
                            </select>
                        </div>
                    </div>

                    <div class="checkbox_area left">
                        <input type="radio" name="changed" value="all" <?php if(!isset($_GET['checked']) OR $_GET['checked']=='all') echo "checked"; ?>> All<br>
                        <input type="radio" name="changed" value="1"  <?php Lib_HelperService::ifChecked('changed', '1')  ?> > Changed<br>
                        <input type="radio" name="changed" value="0"  <?php Lib_HelperService::ifChecked('changed', '0')  ?> > Not changed
                    </div>
                    <div class="checkbox_area left">
                        <input type="radio" name="published" value="all"<?php if(!isset($_GET['published']) OR $_GET['published']=='all') echo "checked"; ?> > All<br>
                        <input type="radio" name="published" value="1" <?php Lib_HelperService::ifChecked('published', '1')  ?> > Published<br>
                        <input type="radio" name="published" value="0" <?php Lib_HelperService::ifChecked('published', '0')  ?> > Not Published
                    </div>

                    <input type="submit" value="OK" class="select_submit_button left">
                </form>

                <a href="/admin/comment/index" class="right menu_button">Reset all settings</a>
            </div>


        <?php if(!empty($comments)) : ?>


         <!-- <div class="articles_good">-->
            <div class="comments_area">
                <table>
                    <tr><th>№</th><th>Title(id)</th><th>Avatar</th><th>Name</th><th>Email</th><th>Comment</th><th>Created</th><th>Changed</th><th>Published</th></tr>
                    <?php foreach($comments as $one): ?>

                        <tr data-comment_id="<?php echo $one['id']; ?>">

                            <td> <?php echo $one['number'] ?></td>
                            <td><?php echo $one['title'].' ( '.$one['product_id'].')'; ?></td>
                            <td><?php if(!empty($one['avatar'])){   ?> <img src="/uploads/avatars/<?php echo $one['avatar']; ?>" > <?php } ?></td>
                            <td><?php echo $one['name']; ?></td>
                            <td><?php echo $one['email']; ?></td>
                            <td><?php echo $one['comment']; ?></td>
                            <td><?php echo $one['created_at']; ?></td>

                            <td class=" <?php if($one['changed']=='1') { echo "unchanged"; } else {echo "changed";} ?>"><?php if ($one['changed']=='1') { echo 'YES';} else { echo "NO";} ?></td>
                            <td class="published_status <?php if($one['published']=='1') { echo "published"; } else {echo "unpublished";} ?>"><?php if ($one['published']=='1') { echo 'YES';} else { echo "NO";} ?></td>
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



    </div>

</div>

