<div class="commentBlock">
    <h2>Додайте Ваш комментар</h2>


    <?php include('uploadimage/index.php'); ?>


    <form method="post" >
        <p>Поля обозначеные <span class="red">*</span> есть обязательными</p>
        <br>



        <label for="name">Имя<span class="red">*</span></label>  <small class="red"><?php if(isset($error['name'])) echo $error['name']; ?></small>
        <p> <input type="text" name="name" id="name" placeholder="Введите Ваше Имя" class="input <?php if(isset($error['name'])) echo 'error'; ?>"
                   value="<?php if(isset($post['name'])) echo $post['name']; ?>" maxlength="15" required ></p>

        <label for="email">Email<span class="red">*</span></label>   <small class="red"><?php if(isset($error['email'])) echo $error['email']; ?></small>
        <p><input type="email" name="email" id="email" placeholder="Введите Ваш почтовый ящик" class="input <?php if(isset($error['email'])) echo 'error'; ?>"
                  value="<?php if(isset($post['email'])) echo $post['email']; ?>" maxlength="15" required ></p>

        <label for="message">Ваше Сообщение<span class="red">*</span></label>   <small class="red"><?php if(isset($error['message'])) echo $error['message']; ?></small>
        <p><textarea name="message" id="message" placeholder="Введите Ваше сообщение" cols="40" rows="8"
                     class="input <?php if(isset($error['message'])) echo 'error'; ?>" required ><?php if(isset($post['message'])) echo $post['message']; ?></textarea></p>

        <small>Кликните по рисунку чтобы обновить капчу</small>
        <p><img src="<?php echo URL ?>lib/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" id="kcaptcha"></p>
        <label for="keystring">Введите капчу<span class="red">*</span></label>   <small class="red"><?php if(isset($error['keystring'])) echo $error['keystring']; ?></small>

        <p><input type="text" name="keystring" id="keystring" class="input <?php if(isset($error['keystring'])) echo 'error'; ?>" maxlength="10" required ></p>

        <p><input type="hidden" name="_token" id="commentForm_token" value="<?php Lib_TokenService::_token('comment_form'); ?>"></p>
        <br>
        <p><input type="submit" id="submitComment" value="Отправить"></p>
    </form>

</div>