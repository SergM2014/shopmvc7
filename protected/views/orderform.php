<span  class="order_close red right">X</span>

<?php if(isset($success)): ?>
    <h2 class="success"> Ваш заказ прийнято мы свяжемось з вами самим найближчим часом</h2>

<?php else: ?>

<div id="orderform">
    <h2 class="red">Форма для заполнения</h2>
    <form method="post" action="/bigbusket/order">
        <p>Поля обозначеные <span class="red">*</span> есть обязательными</p>
        <br>

        <label for="name">Имя<span class="red">*</span></label>  <small class="red"><?php if(isset($error['name'])) echo $error['name']; ?></small>
        <p> <input type="text" name="name" id="name" placeholder="Введите Ваше Имя" class="input <?php if(isset($error['name'])) echo "error"; ?>"
                   value="<?php if(isset($post['name'])) echo $post['name']; ?>" required ></p>

        <label for="phone" >Телефон<span class="red">*</span></label>   <small class="red"><?php if(isset($error['phone'])) echo $error['phone']; ?></small>
        <p><input type="tel" name="phone" id="phone" placeholder="Введите Ваш телефон" class="input <?php if(isset($error['phone'])) echo "error"; ?>"
                  value="<?php if(isset($post['phone'])) echo $post['phone']; ?>" required ></p>

        <label for="email">Email</label>
        <p><input type="email" name="email" id="email" placeholder="Введите Ваш почтовый ящик" class="input"
                  value="<?php if(isset($post['email'])) echo $post['email']; ?>"  ></p>

        <label for="message">Ваше Сообщение</label>
        <p><textarea name="message" id="message" placeholder="Введите Ваше сообщение" cols="40" rows="8"
                class=" input" ><?php if(isset($post['message'])) echo $post['message']; ?></textarea></p>

        <small>Кликните по рисунку чтобы обновить капчу</small>
        <p><img src="<?php echo URL ?>lib/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" id="kcaptcha"></p>
        <label for="keystring">Введите капчу<span class="red">*</span></label>
        <p><input type="text" name="keystring" id="keystring" class="input <?php if(isset($error['keystring'])) echo "error"; ?>" required ></p>

        <input type="hidden" name="_token" id="_token" class="input" value="<?php echo AppUser::_token('orderForm'); ?>">
        <br>
        <p><input type="submit" id="send_order" value="Отправить"></p>
    </form>
</div>

<button class="order_close red right">Закрыть форму</button>


<?php endif; ?>