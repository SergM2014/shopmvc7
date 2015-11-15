

<?php if($goods): ?>
    <section class="big_busket">
        <h2 >Содержимое корзины</h2>
            <table>
                <tr>
                    <th></th>
                    <th >Назва</th>
                    <th>Автор</th>
                    <th>Категория</th>
                    <th>Производитель</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th></th>
                </tr>
                <?php foreach ($goods as $good) : ?>
                <tr>
                    <td class="red"><?php static $i=1; echo $i; $i++; ?></td>
                    <td><?php echo $good['title'] ; ?></td>
                    <td><?php echo $good['author']; ?></td>
                    <td><?php echo $good['cat_title']; ?></td>
                    <td><?php echo $good['manf_title']; ?></td>
                    <td><?php echo $good['price']; ?></td>
                    <td><input type="text" name="<?php echo $good['product_id']; ?>" id="product_id-<?php echo $good['product_id'] ?>" value="<?php echo $good['number']; ?>" maxlength="3"> </td>
                    <td><button>Удалить</button></td>

                </tr>
                <?php endforeach; ?>

            </table>
        <button class="right busket_bottom">Сделать заказ</button>
        <button class="right busket_bottom" id="recount_busket">Пересчитать количество</button>

    </section>
<?php else: ?>
    <h2>Ваша Корзина по прежнему пуста!</h2>
<?php endif; ?>
