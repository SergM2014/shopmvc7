<?php
if(empty($results)): ?>

<h4>Нажаль ничего не найдено</h4>

<?php else: ?>

<?php
foreach($results as $one ): ?>



    <p id="<?php echo $one['product_id'] ?>" class="date_to_preview"><?php echo $one['title'].'  '.$one['author']; ?></p>

<?php endforeach; ?>


<?php endif; ?>