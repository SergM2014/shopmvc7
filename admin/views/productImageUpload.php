
    <h4 <?php if(isset($image)) echo ' class="invisible"'; ?> > Додать изображение</h4>

    <form enctype="multipart/form-data" method="post" class=" MyUploadForm clearfix" >

        <div class="image_form">

            <?php if(isset($image)) : ?>

                  <img class="thumb uploaded" src="/uploads/product_images/thumbs/<?php echo $image; ?> " alt="Просмотреть картинку" > <?php else: ?>
            <img class="thumb" src="/img/nophoto.jpg" > <?php endif; ?>

            <input name="FileInput" id="FileInput>" class="FileInput <?php if(isset($image)) echo 'invisible' ?>" type="file"  >

             <img src="/img/tick.jpg" class="success_tick invisible" >
             <div class="output invisible" ></div>


            <img src="<?php echo '/img/upload.png' ?>"  alt="Загрузить изображение" class="submit_btn invisible">
            <img src="<?php echo '/img/close.png' ?>"  alt="Удалить изображение" class="note reset_btn <?php if(!isset($image)) echo 'invisible'; ?>">




            <div  class="progress invisible">
                <div class="progress-bar"   style="width: 0">
                    0%
                </div>
            </div>
        </div><!--image form -->
    </form>





