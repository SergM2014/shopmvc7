
<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>About us</span>

</nav>

<div class="content clearfix">

    <div class="main-content">

        <form action="/admin/aboutus/update">

            <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('about_us'); ?>" >

            <p class="red">Дозволены любые безвредные теги!</p>
            <textarea name="editor1" id="editor1" class="editor1" rows="10" cols="80">
               <?php echo $aboutus; ?>
            </textarea>

            <br>


            <button id="update_about_us">Update About Us</button>

        </form>


    </div>

    <script src="/ckeditor/ckeditor.js"></script>

    <script>CKEDITOR.replace('editor1');</script>

</div>