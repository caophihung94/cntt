<!-- Page Head -->
<h2>Quản lí bài viết</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa bài viết</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_post/post/view"><i class="fa fa-list"></i> Danh sách bài viết</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-pencil-square-o"></i> Sửa bài viết</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tên bài viết</label>
                        <input class="text-input medium-input" type="text" name="post_name" value="<?php echo set_value('post_name', stripslashes($post['post_name'])); ?>" required/>
                        <?php echo form_error('post_name', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>

                    <p>
                        <label>Hình minh họa (không bắt buộc)</label>
                        <input class="text-input medium-input" type="text" id="image" name="image" maxlength="500" value="<?php echo set_value('image', stripslashes($post['post_image'])); ?>"/>
                        <a href="<?php echo base_url('/filemanager/dialog.php?type=1&field_id=image&akey=ckasbvbazk30-0647290zlngfv07lsjxsin'); ?>" class="btn iframe-btn button" type="button">Duyệt</a>
                        <?php echo form_error('image', '<span class="input-notification error png_bg">', '</span>'); ?>

                    </p>
                    <p>
                        <label>Từ khóa (không bắt buộc)</label>
                        <input class="text-input medium-input" type="text" name="keyword" maxlength="500" value="<?php echo set_value('keyword', stripslashes($post['post_keyword'])); ?>" />
                        <?php echo form_error('keyword', '<span class="input-notification error png_bg">', '</span>'); ?>

                    </p>

                    <p>

                        <label>Mô tả cho bài viết (không bắt buộc)</label>

                        <textarea class="text-input medium-input" name="description" rows="8" maxlength="500"><?php echo set_value('description', stripslashes($post['post_description'])) ?></textarea>

                        <?php echo form_error('description', '<span class="input-notification error png_bg">', '</span>'); ?>

                    </p>

                    <p>

                        <label>Chuyên mục</label>

                        <?php echo isset($dropdown_category) ? form_dropdown('parent', $dropdown_category, $post['post_category'], 'class="medium-input"') : ''; ?>

                        <?php echo form_error('parent', '<span class="input-notification error png_bg">', '</span>'); ?>

                    </p>
                    <p>
                        <label>Nội dung bài viết</label>
                        <?php echo form_error('post_content', '<span class="input-notification error png_bg">', '</span>'); ?>
                        <textarea class="text-input medium-input textarea" name="post_content" rows="8"><?php echo set_value('post_content', stripslashes($post['post_content'])) ?></textarea>
                    </p>

                    <p>

                        <label>Bài viết nổi bật</label>

                        <input type="radio" name="feature" value="0" <?php echo $post['post_feature'] == 0 ? 'checked' : '' ?>> Không

                        <input type="radio" name="feature" value="1"<?php echo $post['post_feature'] == 1 ? 'checked' : '' ?>> Có

                        <?php echo form_error('feature', '<span class="input-notification error png_bg">', '</span>'); ?>

                    </p>
                    <p>

                        <label>Trạng thái</label>

                        <input type="radio" name="post_status" value="0" <?php echo $post['post_status'] == 0 ? 'checked' : '' ?>> Lưu nháp

                        <input type="radio" name="post_status" value="1" <?php echo $post['post_status'] == 1 ? 'checked' : '' ?>> Xuất bản

                        <?php echo form_error('post_status', '<span class="input-notification error png_bg">', '</span>'); ?>

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