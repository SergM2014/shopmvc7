<span class="red right" id="busket_close">X</span>
<h2>Big Busket</h2>

<table>
<tr><th>Название</th><th>Автор</th><th>Цена</th><th>Количество</th></tr>
<?php foreach ($items as $item): ?>
<tr><td><?php echo $item['title']; ?></td><td><?php echo $item['author'] ?></td><td><?php echo $item['price'] ?></td>
    <td><input type="text" value=" <?php echo $item['number'] ?>"  id="<?php echo $item['product_id'] ?>" size="5"></td></tr>


<?php endforeach; ?>

</table>
<button id="recount_busket" class="right">Пересчитать</button>
<strong class="red right">Загальна сумма: <?php echo $_SESSION['totalsum'] ?> грн.</strong>