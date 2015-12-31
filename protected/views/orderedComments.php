



    <?php foreach($comments as $comment): ?>


        <article class="the_comment">
            <div class="left left_of_comment ">
                <?php if (isset($comment['avatar'])){ ?> <p><img src="/uploads/avatars/<?php echo $comment['avatar']; ?>" > </p> <?php } ?>
                <b> <?php echo $comment['name'] ?></b>
            </div>
            <div class="right_of_comment">
                <i><?php echo $comment['comment'] ?></i>

            </div>
            <b class="comment_time red" ><?php echo date('d-m-Y H:i',strtotime($comment['created_at'])); ?></b>
        </article>



    <?php endforeach; ?>

