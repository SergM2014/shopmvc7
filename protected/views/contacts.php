<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>">Головна</a> / <span>Контакты</span>

</nav>

<div class="the_content clearfix">
    <section class="contacts">

        <?php if(isset($success)): ?>
        <h2> You letter is dispatch</h2>
        <?php else: ?>

        <div class="map <?php if (isset($_POST['_token'])) echo 'invisible'; ?>">
            <button id="writeUs">Напиши нам письмецо</button>
            <div id="map"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d164524.0836798843!2d31.088186765820314!3d49.88587031330192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1suk!2sua!4v1447865358584" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>
        </div>

        <div class="writeUsBlock <?php if (!isset($_POST['_token'])) echo 'invisible'; ?>">
            <form method="post">
                <p>Поля обозначеные <span class="red">*</span> есть обязательными</p>
                <br>

                <label for="name">Имя<span class="red">*</span></label>  <small class="red"><?php if(isset($error['name'])) echo $error['name']; ?></small>
               <p> <input type="text" name="name" id="name" placeholder="Введите Ваше Имя" <?php if(isset($error['name'])) echo 'class="error"'; ?>
                          value="<?php if(isset($post['name'])) echo $post['name']; ?>" maxlength="15" required ></p>

                <label for="phone" >Телефон<span class="red">*</span></label>   <small class="red"><?php if(isset($error['phone'])) echo $error['phone']; ?></small>
                <p><input type="tel" name="phone" id="phone" placeholder="Введите Ваш телефон" <?php if(isset($error['phone'])) echo 'class="error"'; ?>
                          value="<?php if(isset($post['phone'])) echo $post['phone']; ?>" maxlength="18" required  ></p>

                <label for="email">Email<span class="red">*</span></label>   <small class="red"><?php if(isset($error['email'])) echo $error['email']; ?></small>
                <p><input type="email" name="email" id="email" placeholder="Введите Ваш почтовый ящик" <?php if(isset($error['email'])) echo 'class="error"'; ?>
                          value="<?php if(isset($post['email'])) echo $post['email']; ?>" maxlength="15" required ></p>

                <label for="message">Ваше Сообщение<span class="red">*</span></label>   <small class="red"><?php if(isset($error['message'])) echo $error['message']; ?></small>
                <p><textarea name="message" id="message" placeholder="Введите Ваше сообщение" cols="40" rows="8"
                        <?php if(isset($error['message'])) echo 'class="error"'; ?> required ><?php if(isset($post['message'])) echo $post['message']; ?></textarea></p>

                <small>Кликните по рисунку чтобы обновить капчу</small>
                <p><img src="<?php echo URL ?>lib/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" id="kcaptcha"></p>
                <label for="keystring">Введите капчу<span class="red">*</span></label>   <small class="red"><?php if(isset($error['keystring'])) echo $error['keystring']; ?></small>
                <p><input type="text" name="keystring" id="keystring" <?php if(isset($error['keystring'])) echo 'class="error"'; ?> maxlength="10" required ></p>

                <p><input type="hidden" name="_token" value="<?php Lib_TokenService::_token('contact_form'); ?>"></p>
                <br>
                <p><input type="submit" value="Отправить"></p>
            </form>
        </div>

        <?php endif; ?>

    </section>
</div>