<!-- Page Head -->
<h2>Cài đặt</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Cài đặt trang web</h3>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
         <?php
        $message_flashdata = $this->session->flashdata('message_flashdata');
        if (isset($message_flashdata) && count($message_flashdata)) {
            if ($message_flashdata['status'] == 'success') {
                ?>
                <div class="notification success png_bg">
                    <a href="#" class="close"><img src="<?php echo base_url() . 'template/backend/simplaAdmin'; ?>/images/icons/cross_grey_small.png" title="Tắt thông báo này" alt="close"></a>
                    <div>
                        <?php echo $message_flashdata['message']; ?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="notification error png_bg">
                    <a href="#" class="close"><img src="<?php echo base_url() . 'template/backend/simplaAdmin'; ?>/images/icons/cross_grey_small.png" title="Tắt thông báo này" alt="close"></a>
                    <div>
                        <?php echo $message_flashdata['message']; ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="tab-content default-tab">
            <form action="" method="post">
                <fieldset>
                    <p>
                        <label>Tên khoa</label>
                        <input class="text-input medium-input" type="text" name="company_name" value="<?php echo stripslashes($setting['company_name']); ?>"/>
                        <?php echo form_error('company_name', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Banner</label>
                        <input class="text-input medium-input" type="text" id="banner" name="banner" value="<?php echo stripslashes($setting['banner']); ?>"/>
                        <a href="<?php echo base_url('/filemanager/dialog.php?type=1&field_id=banner&akey=ckasbvbazk30-0647290zlngfv07lsjxsin'); ?>" class="btn iframe-btn button" type="button">Duyệt</a>
                        <?php echo form_error('banner', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Website</label>
                        <input class="text-input medium-input" type="url" name="url" value="<?php echo stripslashes($setting['url']); ?>"/>
                        <?php echo form_error('url', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Tiêu đề website</label>
                        <input class="text-input medium-input" type="text" name="title_website" value="<?php echo stripslashes($setting['title_website']); ?>"/>
                        <?php echo form_error('title_website', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Email</label>
                        <input class="text-input medium-input" type="email" name="email" value="<?php echo stripslashes($setting['email']); ?>"/>
                        <?php echo form_error('email', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Số điện thoại</label>
                        <input class="text-input medium-input" type="text" name="phone_number" value="<?php echo stripslashes($setting['phone_number']); ?>"/>
                        <?php echo form_error('phone_number', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Địa chỉ</label>
                        <textarea class="text-input medium-input" rows="5" name="address"><?php echo stripslashes($setting['address']); ?></textarea>
                        <?php echo form_error('address', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Bản đồ</label>
                        <textarea class="text-input medium-input" rows="5" name="map"><?php echo stripslashes($setting['map']); ?></textarea>
                        <?php echo form_error('map', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Facebook</label>
                        <input class="text-input medium-input" type="text" name="facebook" value="<?php echo stripslashes($setting['facebook']); ?>"/>
                        <?php echo form_error('facebook', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Twitter</label>
                        <input class="text-input medium-input" type="text" name="twitter" value="<?php echo stripslashes($setting['twitter']); ?>"/>
                        <?php echo form_error('twitter', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Yahoo</label>
                        <input class="text-input medium-input" type="text" name="yahoo" value="<?php echo stripslashes($setting['yahoo']); ?>"/>
                        <?php echo form_error('yahoo', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Youtube</label>
                        <input class="text-input medium-input" type="text" name="youtube" value="<?php echo stripslashes($setting['youtube']); ?>"/>
                        <?php echo form_error('youtube', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Từ khóa</label>
                        <input class="text-input medium-input" type="text" name="keywords" value="<?php echo stripslashes($setting['keywords']); ?>"/>
                        <?php echo form_error('keywords', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Mô tả</label>
                        <textarea class="text-input medium-input" rows="5" name="description"><?php echo stripslashes($setting['description']); ?></textarea>
                        <?php echo form_error('description', '<span class="input-notification error png_bg">', '</span>'); ?>
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