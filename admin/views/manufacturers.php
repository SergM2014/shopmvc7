<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>admin">Головна</a> / <span>Manufacturers</span>

</nav>

<div class="content clearfix">

    <div class="main-content">

        <input type="hidden" name="_token" id="delete_manufacturer_token" value="<?php Lib_TokenService::_token('delete_manufacturer') ?>" >

        <h2>Manufacturers</h2>
            <ul class="admin_manufacturers">
        <?php foreach ($manufacturers as $manufacturer){ ?>


            <li><span class="admin_manufacturers_item" data-manufacturer_id=<?php echo $manufacturer['id']; ?>> <?php echo $manufacturer['title']; ?></span></li>
<?php
        }
        ?>
        </ul>
</div>

</div>