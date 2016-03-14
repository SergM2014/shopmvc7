<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Contact us</span>

</nav>

<div class="content clearfix">

    <div class="main-content">

        <form action="/admin/contactus/update">

            <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('contacts'); ?>" >

            <p id="saving_info" class="green"><p>

            <p class="red">Дозволены любые безвредные теги!</p>
            <textarea name="editor1" id="editor1" class="editor1" rows="10" cols="80">
               <?php echo $contacts; ?>
            </textarea>

            <br>


            <button id="update_contact_us">Update Contact Us</button>

        </form>


    </div>

    <script src="/ckeditor/ckeditor.js"></script>

    <script>CKEDITOR.replace('editor1');</script>

</div>