

    <?php $_SESSION['image_id']+=1; ?>

    <label for="FileInput_<?php echo $_SESSION['image_id']; ?>" > Додать изображение</label>

    <form enctype="multipart/form-data" method="post" class=" MyUploadForm clearfix" >

        <div class="image_form">
            <img alt="" id="image_preview_<?php echo $_SESSION['image_id']; ?>" class="thumb" src="/img/nophoto.jpg"  />
            <input name="FileInput_<?php echo $_SESSION['image_id']; ?>" id="FileInput_<?php echo $_SESSION['image_id']; ?>" class="FileInput" type="file" data-id="<?php echo $_SESSION['image_id']; ?>" >

             <img src="/img/tick.jpg" class="success_tick invisible" id="success_tick_<?php echo $_SESSION['image_id']; ?>" >
             <div id="output_<?php echo $_SESSION['image_id']; ?>" class=" output invisible" ></div>


            <img src="<?php echo '/img/upload.png' ?>" id="submit_btn_<?php echo $_SESSION['image_id']; ?>" alt="Загрузить изображение" class="submit_btn invisible">
            <img src="<?php echo '/img/close.png' ?>" id="reset_btn_<?php echo $_SESSION['image_id']; ?>" alt="Удалить изображение" class="note reset_btn invisible">




            <div id="progress_<?php echo $_SESSION['image_id']; ?>" class="progress left">
                <div class="progress-bar invisible"   style="width: 0">
                    0%
                </div>
            </div>
        </div><!--image form -->
    </form>





