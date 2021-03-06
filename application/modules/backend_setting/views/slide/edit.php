<!-- Page Head -->
<h2>Quản lí Slide</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa ảnh</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_setting/slide/view"><i class="fa fa-list"></i> Danh sách ảnh</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-plus"></i> Sửa ảnh</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Chọn ảnh(bắt buộc)</label>
                        <input class="text-input medium-input" type="text" id="image" name="image" value="<?php echo stripslashes($image['image']); ?>" required/>
                        <a href="<?php echo base_url('/filemanager/dialog.php?type=1&field_id=image&akey=ckasbvbazk30-0647290zlngfv07lsjxsin'); ?>" class="btn iframe-btn button" type="button">Duyệt</a>
                        <?php echo form_error('image', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Mô tả (không bắt buộc)</label>
                        <textarea class="text-input medium-input" rows="5" name="caption"><?php echo stripslashes($image['caption']); ?></textarea>
                        <?php echo form_error('caption', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Link liên kết (không bắt buộc)</label>
                        <input class="text-input medium-input" type="text" name="link" value="<?php echo stripslashes($image['link']); ?>"/>
                        <?php echo form_error('link', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>

                    <p>
                        <label>Vị trí</label>
                        <input class="text-input medium-input" type="number" name="position" value="<?php echo $image['position']; ?>" required/>
                        <?php echo form_error('position', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Trạng thái</label>
                        <input type="radio" name="publish" value="0" <?php echo $image['publish'] == 0 ? 'checked' : ''; ?>> Tắt
                        <input type="radio" name="publish" value="1" <?php echo $image['publish'] == 1 ? 'checked' : ''; ?>> Mở
                        <?php echo form_error('publish', '<span class="input-notification error png_bg">', '</span>'); ?>
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