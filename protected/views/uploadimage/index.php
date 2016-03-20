<label for="FileInput" > Додать аватар</label>

<form id="MyUploadForm"  enctype="multipart/form-data" method="post" class="clearfix" >

    <div id="avatar_area"  class="clearfix">
        <img alt="" id="image_preview" class="thumb left" src="<?php if(isset($_SESSION['avatar'])) {echo '/uploads/avatars/'.$_SESSION['avatar'];} else {echo URL.'img/noavatar.jpg';} ?>"  />

        <div class="progress right">
            <div id="progress-bar" class="invisible" role="progressbar"  style="width: 0">
                0%
            </div>
        </div>

    </div>
    <div id="avatarForm">

        <input name="FileInput" id="FileInput" type="file" class="<?php if(isset($_SESSION['avatar'])) echo 'invisible' ?>" >
        <button  id="submit-btn" class="invisible">Загрузить</button>
        <button  id="image-reset-btn"  class="<?php if(!isset($_SESSION['avatar'])) echo "invisible" ?>" > Удалить</button>
    </div>

    <div id="output" class="invisible" ></div>

</form>




