
<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>About us</span>

</nav>

<div class="content clearfix">

    <div class="main-content">

        <form action="/admin/aboutus/update"
        <textarea name="editor1" id="editor1" rows="10" cols="80">
           <?php echo $aboutus; ?>
        </textarea>



    </div>

    <script src="/ckeditor/ckeditor.js"></script>

    <script>CKEDITOR.replace('editor1');</script>

</div>