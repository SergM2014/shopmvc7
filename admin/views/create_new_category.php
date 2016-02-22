<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/category/index">Category</a> / <span>Create New Category</span>

</nav>

<div class="content clearfix">

<h2>Lets create new category!!!</h2>
    <form action="/admin/category/store" method="POST">

        <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('create_new_category')?>">

        <label for="create_new_cat">Enter new category</label>
        <br>
        <p>
        <input type="text" <?php if (isset($error['create_new_category'])) echo 'class="error"'; ?> id="create_new_category" name="create_new_category"
               value="<?php if(isset($category_name)) echo $category_name; ?>" placeholder="Enter the name of new category" >
        <?php if (isset($error['create_new_category'])) echo '<small class="red">'.$error['create_new_category'].'</small>'; ?>
        </p>
        <br>
        <br>
        <label for="">Choose parent category</label>
        <div class="styled-select">
            <?php echo $categories_tree; ?></p>
        </div>
        <br>
        <input type="submit" value="create new category">
    </form>


</div>