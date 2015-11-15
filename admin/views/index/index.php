    <?php
    if(!isset($_SESSION['login'])):
    ?>

        <div class="login_form">
            <h3>Вход в административную зону</h3>
                <div id="login">

                    <fieldset>
                        <form  method="POST" action="/admin/">

                            <label> Логин</label><br>
                            <input   name="login" type="text" value="<?php if(isset($_SESSION['login']))echo $_SESSION['login'] ?>" maxlength="25"><br>
                            <label>Пароль </label><br>
                            <input   name="password" type="password" maxlength="20" ><br>
                            </br>
                            <input  type="submit" value="Войти в админзону">

                        </form>

                    </fieldset>
                </div><!--login -->
        </div><!--login_form-->
    </div><!--frame -->
<?php endif; ?>
</div>
