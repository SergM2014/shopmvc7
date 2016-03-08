<h2>Add Slider</h2>

<section class="slider_image_area clearfix">
    <h4> Add image</h4>

    <form enctype="multipart/form-data" method="post" class=" MyUploadForm clearfix" >

        <div class="image_form <?php if(isset($error['slider_image'])) echo "error";  ?>" >

            <img id="image_preview" class="thumb" src="<?php if(isset($_SESSION['slider'])) {
                echo '/uploads/slider/'.$_SESSION['slider'];
            }  else{
                echo "/img/nophoto.jpg";
            } ?>" >

            <input name="FileInput" id="file_input"  type="file" class="<?php if(isset($_SESSION['slider'])) echo 'invisible' ?>">

            <img src="/img/tick.jpg" class="success_tick invisible" >
            <div class="output invisible" ></div>


            <img src="<?php echo '/img/upload.png' ?>"  alt="Загрузить изображение" class="submit_btn invisible">
            <img src="<?php echo '/img/close.png' ?>"  alt="Удалить изображение" class="note reset_btn <?php if(!isset($_SESSION['slider'])) echo 'invisible'; ?>" >




            <div  class="progress invisible">
                <div class="progress_bar"   style="width: 0">
                    0%
                </div>
            </div>
        </div><!--image form -->
    </form>

    <?php if(isset($error['slider_image'])) : ?> <small class="red"><?php echo $error['slider_image'] ?></small>  <?php endif; ?>

    <script src="/admin/assets/uploadslider.js"></script>
</section>