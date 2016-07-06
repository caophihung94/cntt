<!-- Page Head -->
<h2>Quản lí thành viên</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Xóa thành viên</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_user/user/view"><i class="fa fa-list"></i> Tất cả thành viên</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-trash-o"></i> Xóa thành viên</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <?php
            $redirect = base64_decode($this->input->get('redirect'));
            if (isset($num_post)) {
                //Con thanh vien trong nhom => khong cho xoa
                ?>
                <div class="notification error png_bg">
                    <div>
                        Còn <?php echo $num_post; ?> tài liệu của thành viên này. Hãy di chuyển hoặc xóa tài liệu và thử lại!
                    </div>
                </div>
                <a href="<?php echo $redirect; ?>"><button type="button" class="button">Quay lại</button></a>
            <?php } else {
                ?>
                <form action="" method="post">
                    <fieldset>
                        <div class="notification information png_bg">
                            <div>
                                Bạn có thực sự muốn xóa thành viên này "<?php echo isset($user['name']) ? $user['name'] : ''; ?>" không? <br/>Nhấn "Xác nhận" để xóa!
                            </div>
                        </div>
                        <p>
                            <a href="<?php echo $redirect; ?>"><button type="button" class="button">Quay lại</button></a>
                            <input class="button" type="submit" name="submit" value="Xác nhận" />
                        </p>
                    </fieldset>
                    <div class="clear"></div><!-- End .clear -->
                </form>
            <?php }
            ?>
        </div> <!-- End #tab2 -->        
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>