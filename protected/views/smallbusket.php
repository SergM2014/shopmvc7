<!--те що ми вставляемо в busket content !-->
        <p id="updateSmallBusket_token" class="invisible"><?php Lib_TokenService::_token('update_small_busket'); ?></p>
        <span>Количество: <b><?php echo (isset($_SESSION['totalamount']))? $_SESSION['totalamount']: '0'; ?></b> шт.</span>
        <span>Сума: <b><?php echo (isset($_SESSION['totalsum']))? $_SESSION['totalsum']: '0'; ?></b> грн.</span>


