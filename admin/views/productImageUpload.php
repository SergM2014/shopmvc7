


    <h4 <?php if(isset($image)) echo ' class="invisible"'; ?> > Додать изображение</h4>

    <form enctype="multipart/form-data" method="post" class=" MyUploadForm clearfix" >

        <div class="image_form">
            <img alt=""  class="thumb" src="<?php if(isset($image)) {echo '/uploads/product_images/thumbs/'.$image;} else {echo '/img/nophoto.jpg';} ?>"  />
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





