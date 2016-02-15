    <?php
    if(isset($restriction)) echo $restriction;
    if(!isset($_SESSION['admin'])):
    ?>

        <div class="login_form">
            <h3>Вход в административную зону</h3>
                <div id="login">

                    <fieldset>
                        <form  method="POST" action="/admin/index">
                            <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('enter_admin') ?>">
                           <p><label for="login">Логин</label><br>
                            <input   name="login" id="login" type="text" value="" maxlength="25"> </p>
                            <p><label for="password">Пароль </label><br>
                            <input   name="password" id="password" type="password" maxlength="20" > </p>

                            <p><input  type="submit" value="Войти в админзону"></p>

                        </form>

                    </fieldset>
                </div><!--login-->
        </div><!--login_form


    </div><!--frame-->
<?php endif; ?>



