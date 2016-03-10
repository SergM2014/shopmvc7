<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/comment">Головна</a> / <span>Edit Comments</span>

</nav>

<div class="content clearfix">



    <section id="<?php echo (int)$_GET['id']; ?>" class="edit_images image_area">

        <input type="hidden" name="image_token"  value="<?php Lib_TokenService::_token('upload_image') ?>" data-handle="comment" >

        <?php include PATH_SITE.'/admin/views/partials/image_upload.php'; ?>


        <script src="/admin/assets/uploadimage.js"></script>
    </section>




    <section class="comment_block">

        <h2>Edit комментар</h2>


        <form method="post" action="/admin/comment/update/">

            <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('update_comment') ?>">
            <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">

            <input type="radio" name="published" value="1" <?php if($comment['published']=='1') echo "checked"; ?> > публиковатьe<br>
            <input type="radio" name="published" value="0" <?php if($comment['published']!='1') echo "checked"; ?> > не публиковать<br>
            <br>

            <p>Поля обозначеные <span class="red">*</span> есть обязательными</p>
            <br>


            <label for="name">Редактировать Имя<span class="red">*</span></label>  <small class="red"><?php if(isset($error['name'])) echo $error['name']; ?></small>

            <p> <input type="text" name="name" id="name" placeholder="Введите Ваше Имя" class="input <?php if(isset($error['name'])) echo 'error'; ?>"
                       value="<?php if(isset($comment['name'])) echo $comment['name']; ?>" maxlength="15"  ></p>

            <label for="email">Редактировать Email<span class="red">*</span></label>   <small class="red"><?php if(isset($error['email'])) echo $error['email']; ?></small>

            <p><input type="email" name="email" id="email" placeholder="Введите Ваш почтовый ящик" class="input <?php if(isset($error['email'])) echo 'error'; ?>"
                      value="<?php if(isset($comment['email'])) echo $comment['email']; ?>" maxlength="15"  ></p>

            <label for="message">Редактировать Сообщение<span class="red">*</span></label>   <small class="red"><?php if(isset($error['message'])) echo $error['message']; ?></small>

            <p><textarea name="message" id="message" placeholder="Введите Ваше сообщение" cols="70" rows="20"
                         class="input <?php if(isset($error['message'])) echo 'error'; ?>"  ><?php if(isset($comment['comment'])) echo $comment['comment']; ?></textarea></p>




            <br>
            <p><input type="submit" id="submitComment" value="Change Comment"></p>
        </form>

    </section>



</div>

