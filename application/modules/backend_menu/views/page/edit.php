<!-- Page Head -->
<h2>Quản lí trang</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa trang</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_menu/page/view"><i class="fa fa-list"></i> Danh sách trang</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-pencil-square-o"></i> Sửa trang</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tên trang</label>
                        <input class="text-input medium-input" type="text" name="page_name" maxlength="500" value="<?php echo stripslashes($page['page_name']); ?>" required/>
                        <?php echo form_error('page_name','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Menu</label>
                        <?php echo form_error('menu', '<span class="input-notification error png_bg">', '</span>'); ?>
                        <select name="menu" class="medium-input">
                            <option value="0">--- None ---</option>
                            <?php if (!empty($list_menu)): ?>
                                <?php foreach ($list_menu as $menu): ?>
                                    <option value="<?php echo $menu['id']; ?>" <?php echo ($menu['id'] == $page['menu_id']) ? 'selected="selected"' : ''; ?>>
                                        <?php echo htmlentities(stripslashes($menu['menu_name'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </p>
                    <p>
                        <label>Nội dung</label>
                        <textarea class="text-input medium-input textarea" name="page_content"><?php echo stripslashes($page['page_content']); ?></textarea>
                        <?php echo form_error('page_content','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Vị trí</label>
                        <input class="text-input medium-input" type="number" name="page_position" value="<?php echo $page['page_position']; ?>" required/>
                        <?php echo form_error('page_position','<span class="input-notification error png_bg">', '</span>'); ?>
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