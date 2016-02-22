<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/category/index">Category</a> / <span>Create New Category</span>

</nav>

<div class="content clearfix">
<h2>Lets update category!!!</h2>
    <form action="/admin/category/update" method="POST">

        <input type = "hidden" name = "_token" value = "<?php Lib_TokenService::_token('update_category')?>">
        <input type = "hidden" name = "product_id" value = "<?php echo $category['id']; ?>">
        <label for="update_category">Update category</label>
        <br>
        <br>
        <p>
        <input type="text" <?php if (isset($error['update_category'])) echo 'class="error"'; ?> id="update_category" name="update_category"
               value="<?php if(isset($category['name']) && !isset($error['update_category'])) echo $category['name']; ?>" placeholder="Change category name" >
        <?php if (isset($error['update_category'])) echo '<small class="red">'.$error['update_category'].'</small>'; ?>
        </p>
        <br>
        <input type="submit" value="update category">
    </form>


</div>
