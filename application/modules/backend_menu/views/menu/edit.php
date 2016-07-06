<!-- Page Head -->
<h2>Quản lí menu</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa menu</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_menu/menu/view"><i class="fa fa-list"></i> Danh sách menu</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-pencil-square-o"></i> Sửa menu</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tên menu</label>
                        <input class="text-input medium-input" type="text" name="menu_name" value="<?php echo stripslashes($menu['menu_name']); ?>" required/>
                        <?php echo form_error('menu_name','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Vị trí</label>
                        <input class="text-input medium-input" type="number" name="menu_position" value="<?php echo $menu['menu_position']; ?>" required/>
                        <?php echo form_error('menu_position','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <input class="button" type="submit" name="submit" value="Cập nhật" />
                    </p>
                </fieldset>
                <div class="clear"></div><!-- End .clear -->
            </form>
        </div> <!-- End #tab2 -->
    </div> <!-- End .content-box-content -->	
</div> <!-- End .content-box -->
<div class="clear"></div>