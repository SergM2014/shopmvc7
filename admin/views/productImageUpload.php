

    <?php $_SESSION['image_id']+=1; ?>

    <label for="FileInput_<?php echo $_SESSION['image_id']; ?>" > Додать изображение</label>

    <form enctype="multipart/form-data" method="post" class=" MyUploadForm clearfix" >

        <div class="image_form">
            <img alt="" id="image_preview_<?php echo $_SESSION['image_id']; ?>" class="thumb" src="/img/nophoto.jpg"  />
            <input name="FileInput_<?php echo $_SESSION['image_id']; ?>" id="FileInput_<?php echo $_SESSION['image_id']; ?>" class="FileInput" type="file" data-id="<?php echo $_SESSION['image_id']; ?>" >
        </div>

        <div id="output_<?php echo $_SESSION['image_id']; ?>" class="invisible" ></div>
        <input type="button"  id="submit_btn_<?php echo $_SESSION['image_id']; ?>" class="submit_btn invisible" value="Загрузить"  />
        <button id="reset_btn_<?php echo $_SESSION['image_id']; ?>" class="reset_btn invisible" > Удалить</button>

    </form>

    <div id="progress_<?php echo $_SESSION['image_id']; ?>">
        <div class="progress-bar invisible"   style="width: 0">
            0%
        </div>
    </div>






