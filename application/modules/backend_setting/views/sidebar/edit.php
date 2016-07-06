<!-- Page Head -->
<h2>Quản lí sidebar</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Sửa phần tử</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_setting/sidebar/view"><i class="fa fa-list"></i> Danh sách phần tử</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-pencil-square-o"></i> Sửa phần tử</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tiêu đề (không bắt buộc)</label>
                        <input class="text-input medium-input" type="text" name="title"  value="<?php echo stripslashes($block['title']); ?>" />
                        <?php echo form_error('title','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Mô tả (bắt buộc)</label>
                        <input class="text-input medium-input" type="text" name="description"  value="<?php echo stripslashes($block['description']); ?>" required />
                        <?php echo form_error('description','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Nội dung</label>
                        <textarea class="text-input medium-input textarea" name="content"><?php echo stripslashes($block['content']); ?></textarea>
                        <?php echo form_error('content','<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Vị trí</label>
                        <input class="text-input medium-input" type="number" name="position" value="<?php echo $block['position']; ?>" required/>
                        <?php echo form_error('position','<span class="input-notification error png_bg">', '</span>'); ?>
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