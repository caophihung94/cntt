<h2>Quản lí thành viên</h2>
<div class="clear"></div> 
<div class="content-box">
    <div class="content-box-header">
        <h3>Cập nhật hồ sơ cá nhân</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_user/user/view"><i class="fa fa-list"></i> Tất cả thành viên</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-user-plus"></i> Cập nhật hồ sơ cá nhân</a></li>
        </ul>
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
                        <label>Tên đầy đủ</label>
                        <input class="text-input medium-input" type="text" name="name" value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>" required/>
                        <?php echo form_error('name', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>

                    <p>
                        <label>Email</label>
                        <input class="text-input medium-input" type="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required/>
                        <?php echo form_error('email', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>

                    <p>
                        <label>Mật khẩu cũ (bắt buộc)</label>
                        <input class="text-input medium-input" type="password" name="password" value="" required/>
                        <?php echo form_error('password', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Mật khẩu mới (nhập vào nếu muốn đổi mật khẩu)</label>
                        <input class="text-input medium-input" type="password" name="newPassword" value="" />
                        <?php echo form_error('newPassword', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <label>Nhập lại mật khẩu mới (nhập vào nếu muốn đổi mật khẩu)</label>
                        <input class="text-input medium-input" type="password" name="confirmNewPassword" value="" />
                        <?php echo form_error('confirmNewPassword', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>
                    <p>
                        <button type="reset" class="button">Làm lại</button>
                        <button type="submit" class="button" name="submit" />Cập nhật</button>
                    </p>
                </fieldset>
            </form>
        </div> <!-- End #tab1 -->
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>