<ul>
<?php
foreach($results as $one ): ?>



    <li><a href="#"><?php echo $one['title'].'  '.$one['author']; ?></a></li>

<?php endforeach; ?>

</ul>
