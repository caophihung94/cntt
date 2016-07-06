<!-- Page Head -->
<h2>Quản lí đồ án</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa đồ án</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_post/document/view"><i class="fa fa-list"></i> Danh sách đồ án</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-plus"></i> Sửa đồ án</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tên đề tài</label>
                        <input class="text-input medium-input" type="text" name="doc_name" value="<?php echo set_value('doc_name', stripslashes($document['doc_name'])); ?>" required/>
                        <?php echo form_error('doc_name','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Chọn file đồ án (.doc, .docx, .pdf)</label>
                        <input class="text-input medium-input" type="text" id="doc_file" name="doc_file" required value="<?php echo set_value('doc_file', $document['doc_file']) ?>" />
                        <a href="<?php echo base_url('/filemanager/dialog.php?type=2&field_id=doc_file&akey=ckasbvbazk30-0647290zlngfv07lsjxsin'); ?>" class="btn iframe-btn button" type="button">Duyệt</a>
                        <?php echo form_error('doc_file','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Hình minh họa</label>
                        <input class="text-input medium-input" type="text" id="doc_image" name="doc_image" required value="<?php echo set_value('doc_image', $document['doc_image']) ?>"/>
                        <a href="<?php echo base_url('/filemanager/dialog.php?type=1&field_id=doc_image&akey=ckasbvbazk30-0647290zlngfv07lsjxsin'); ?>" class="btn iframe-btn button" type="button">Duyệt</a>
                        <?php echo form_error('doc_image','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Từ khóa</label>
                        <input class="text-input medium-input" type="text" name="keyword" maxlength="500" value="<?php echo set_value('keyword', stripslashes($document['doc_keyword'])); ?>" />
                        <?php echo form_error('keyword','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Mô tả</label>
                        <textarea class="text-input medium-input" name="description" rows="8" maxlength="500" required><?php echo set_value('description', stripslashes($document['doc_description'])); ?></textarea>
                        <?php echo form_error('description','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Sinh viên thực hiện</label>
                        <input class="text-input medium-input" type="text" name="author" maxlength="128" value="<?php echo set_value('author', stripslashes($document['doc_author'])) ?>" />
                        <?php echo form_error('author','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Giảng viên hướng dẫn</label>
                        <input class="text-input medium-input" type="text" name="instructor" maxlength="60" value="<?php echo set_value('instructor', stripslashes($document['instructor'])); ?>" />
                        <?php echo form_error('instructor','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Năm bảo vệ</label>
                        <input class="text-input medium-input" type="number" name="doc_yearPublish" value="<?php echo set_value('doc_yearPublish', $document['doc_yearPublish']) ?>" min="2004" max="<?php echo date('Y'); ?>" />
                        <?php echo form_error('doc_yearPublish','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Nổi bật</label>
                        <input type="radio" name="doc_feature" value="0" <?php echo $document['doc_feature'] == 0 ? 'checked' : ''; ?>> Không
                        <input type="radio" name="doc_feature" value="1" <?php echo $document['doc_feature'] == 1 ? 'checked' : ''; ?>> Có
                        <?php echo form_error('doc_feature','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Trạng thái</label>
                        <input type="radio" name="doc_status" value="0" <?php echo $document['doc_status'] == 0 ? 'checked' : ''; ?>> Lưu nháp
                        <input type="radio" name="doc_status" value="1" <?php echo $document['doc_status'] == 1 ? 'checked' : ''; ?>> Xuất bản
                        <?php echo form_error('doc_status','<span class="input-notification error png_bg">', '</span>'); ?>
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