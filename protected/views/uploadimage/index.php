<label for="FileInput" > Додать аватар</label>

<form id="MyUploadForm"  enctype="multipart/form-data" method="post" a class="clearfix" >

    <div id="for_input">
        <img alt="" id="image_preview" class="thumb" src="<?php if(isset($_SESSION['avatar'])) {echo 'uploads/'.$_SESSION['avatar'];} else {echo URL.'img/noavatar.jpg';} ?>"  />
        <input name="FileInput" id="FileInput" type="file" <?php if(isset($_SESSION['avatar1'])) echo "style='display:none'" ?>/>
    </div>
    <div id="output" class="invisible" ></div>
    <input type="button"  id="submit-btn" class="invisible" value="Загрузить"  />
    <button  id="image-reset-btn"  class="invisible" <?php if(isset($_SESSION['avatar1'])) echo "style='display:block'" ?> > Удалить</button>

</form>

<div class="progress">
    <div id="progress-bar" class="invisible" role="progressbar"  style="width: 0">
        0%
    </div>
</div>
