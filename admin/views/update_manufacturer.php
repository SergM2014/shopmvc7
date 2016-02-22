<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <a href="<?php echo URL; ?>admin/manufacturers">Manufacturers</a> / <span>Update Manufacturer</span>

</nav>

<div class="content clearfix">

    <div class="main-content">
        <h2>Update new manufacturer!</h2>
        <form action="/admin/manufacturer/update" method="POST">
            <input type="hidden" name="_token" value="<?php Lib_TokenService::_token('update_manufacturer'); ?>">
            <input type = "hidden" name = "manufacturer_id" value = "<?php echo $manufacturer_id; ?>">

            <p><label for="add_manufacturer_name">Add Manufacturer Name</label></p>
            <p><input type="text" id="add_manufacturer_name" name="add_manufacturer_name" <?php if (isset($error['add_manufacturer_name'])) echo 'class="error"'; ?>
                      value="<?php if(isset($manufacturer_name)) echo $manufacturer_name; ?>" placeholder="enter new manufacturer" >
                <?php if (isset($error['add_manufacturer_name'])) echo '<small class="red">'.$error['add_manufacturer_name'].'</small>'; ?>
            </p>

            <p><label for="add_manufacturer_url">Add Manufacture Url</label></p>
            <p><input type="text" id="add_manufacturer_url" name="add_manufacturer_url" <?php if (isset($error['add_manufacturer_url'])) echo 'class="error"'; ?>
                      value="<?php if(isset($manufacturer_url)) echo $manufacturer_url; ?>" placeholder="enter manufacturer url" >
                <?php if (isset($error['add_manufacturer_url'])) echo '<small class="red">'.$error['add_manufacturer_url'].'</small>'; ?>
            </p>
            <br>
            <br>
            <input type="submit" value="Update Manufacturer">
        </form>

    </div>

</div>