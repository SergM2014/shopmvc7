<span class="red right" id="busket_close">X</span>

<?php if($items): ?>
<h2>Big Busket</h2>

<table>

    <tr><th>Название</th><th>Автор</th><th>Цена</th><th>Количество</th></tr>
    <?php foreach ($items as $item): ?>
    <tr><td><?php echo $item['title']; ?></td><td><?php echo $item['author'] ?></td><td><?php echo $item['price'] ?></td>
        <td><input type="text" value=" <?php echo $item['number'] ?>"  id="<?php echo $item['id'] ?>" size="5" data-price="<?php echo $item['price']; ?>"></td></tr>
    <?php endforeach; ?>

</table>

    <input type="hidden" id="updateBusket_token" value="<?php echo AppUser::_token('updateBusket') ?>" >
<button id="make_order" class="right">Сделать заказ</button>
<button id="recount_busket" class="right">Пересчитать</button>
<strong class="red right">Загальна сумма: <?php echo $_SESSION['totalsum'] ?> грн.</strong>
<?php else: ?>
    <h2>Ваша корзина по прежнему пуста!</h2>
<?php endif; ?>
