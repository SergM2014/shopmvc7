<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Categories</span>

</nav>

<div class="content clearfix">

    <div class="main-content">
    <form>
    	<input type="hidden" name="_token" id="delete_category_token" value="<?php Lib_TokenService::_token('delete_category') ?>" >
    </form>  
        <h2>Categories</h2>

       <!-- <a href="/admin/category/create" class="button">+ Add main category</a>-->

        <ul class="admin_categories">
            <?php echo $categories_tree; ?></p>
        </ul>
    </div>

</div>