<span  class="order_close red right">X</span>

<div id="orderform">
    <h2 class="red">Форма для заполнения</h2>
    <form method="post">
        <p>Поля обозначеные <span class="red">*</span> есть обязательными</p>
        <br>

        <label for="name">Имя<span class="red">*</span></label>  <small class="red"><?php if(isset($error['name'])) echo $error['name']; ?></small>
        <p> <input type="text" name="name" id="name" placeholder="Введите Ваше Имя" <?php if(isset($error['name'])) echo 'class="error"'; ?>
                   value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" required ></p>

        <label for="phone" >Телефон<span class="red">*</span></label>   <small class="red"><?php if(isset($error['phone'])) echo $error['phone']; ?></small>
        <p><input type="tel" name="phone" id="phone" placeholder="Введите Ваш телефон" <?php if(isset($error['phone'])) echo 'class="error"'; ?>
                  value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" required ></p>

        <label for="email">Email   <small class="red"><?php if(isset($error['email'])) echo $error['email']; ?></small>
        <p><input type="email" name="email" id="email" placeholder="Введите Ваш почтовый ящик" <?php if(isset($error['email'])) echo 'class="error"'; ?>
                  value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required ></p>

        <label for="message">Ваше Сообщение</label>   <small class="red"><?php if(isset($error['message'])) echo $error['message']; ?></small>
        <p><textarea name="message" id="message" placeholder="Введите Ваше сообщение" cols="40" rows="8"
                <?php if(isset($error['message'])) echo 'class="error"'; ?> required ><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea></p>

        <small>Кликните по рисунку чтобы обновить капчу</small>
        <p><img src="<?php echo URL ?>lib/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" id="kcaptcha"></p>
        <label for="keystring">Введите капчу<span class="red">*</span></label>   <small class="red"><?php if(isset($error['keystring'])) echo $error['keystring']; ?></small>
        <p><input type="text" name="keystring" id="keystring" <?php if(isset($error['keystring'])) echo 'class="error"'; ?> required ></p>

        <input type="hidden" name="send" value="true">
        <br>
        <p><input type="submit" value="Отправить"></p>
    </form>
</div>

<button class="order_close red right">Закрыть форму</button>