<!-- Page Head -->
<h2>Quản lí danh mục</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa danh mục</h3>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <?php echo validation_errors(); ?>
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tên danh mục</label>
                        <input class="text-input medium-input" type="text" name="cat_name" value="<?php echo set_value('cat_name', $category['cat_name']) ?>" />
                        <?php echo form_error('cat_name','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Mô tả cho danh mục</label>
                        <textarea class="text-input medium-input" name="description" rows="8"><?php echo set_value('description', $category['description']) ?></textarea>
                        <?php echo form_error('description','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Từ khóa</label>
                        <input class="text-input medium-input" type="text" name="keyword" value="<?php echo set_value('keyword', $category['keyword']) ?>" />
                        <?php echo form_error('keyword','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Vị trí</label>
                        <input class="text-input medium-input" type="number" name="position" value="<?php echo set_value('position', $category['cat_position']) ?>" required />
                        <br>
                        <small>Danh mục sẽ được sắp xếp tăng dần dựa vào vị trí này</small>
                        <?php echo form_error('position', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Chuyên mục cha</label>
                        <?php echo isset($dropdown_category)?form_dropdown('parent', $dropdown_category, $category['parent_id'], 'class="form-control" '):''; ?>
                        <?php echo form_error('parent','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Xuất bản</label>
                        <?php echo form_error('publish','<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Đóng"><span aria-hidden="true">×</span></button>', '</div>'); ?>
                        <select class="form-control" name="publish">
                            <option value="0" <?php echo ($category['publish']== 0)?'selected="selected"':''; ?>>Không</option>
                            <option value="1" <?php echo ($category['publish']== 1)?'selected="selected"':''; ?>>Có</option>
                        </select>
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