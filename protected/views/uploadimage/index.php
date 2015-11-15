<label for="FileInput" > Додать аватар</label>

<form id="MyUploadForm"  enctype="multipart/form-data" method="post" action="protected/ajax/upload.php" class="clearfix" >

    <div id="for_input">
        <img alt="" id="image_preview" class="thumb" src="<?php if($_SESSION['bild']) {echo 'uploads/'.$_SESSION['bild'];} else {echo 'images/noavatar.jpg';} ?>"  />
        <input name="FileInput" id="FileInput" type="file" <?php if($_SESSION['bild']) echo "style='display:none'" ?>/>
    </div>
    <div id="output" class="unvisible" ></div>
    <input type="button"  id="submit-btn" class="invisible" value="Загрузить"  />
    <input type="reset"  id="reset-btn"  class="invisible" value="Удалить" <?php if($_SESSION['bild']) echo "style='display:block'" ?> />

</form>

<div class="progress">
    <div id="progress-bar" class="unvisible" role="progressbar"  style="width: 0">
        0%
    </div>
</div>
