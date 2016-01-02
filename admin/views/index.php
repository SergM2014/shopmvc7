    <?php
    if(!isset($_SESSION['admin'])):
    ?>

        <div class="login_form">
            <h3>Вход в административную зону</h3>
                <div id="login">

                    <fieldset>
                        <form  method="POST" action="/admin">
                            <input type="hidden" name="_token" value="<?php echo AppUser::_token('enterAdmin') ?>">
                           <p><label for="login">Логин</label><br>
                            <input   name="login" id="login" type="text" value="<?php if(isset($_SESSION['admin']))echo $_SESSION['admin'] ?>" maxlength="25"> </p>
                            <p><label for="password">Пароль </label><br>
                            <input   name="password" id="password" type="password" maxlength="20" > </p>

                            <p><input  type="submit" value="Войти в админзону"></p>

                        </form>

                    </fieldset>
                </div><!--login-->
        </div><!--login_form


    </div><!--frame-->
<?php endif; ?>


