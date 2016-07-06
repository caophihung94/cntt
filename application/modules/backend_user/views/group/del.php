<!-- Page Head -->
<h2>Quản lí nhóm quyền</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Xóa nhóm quyền</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_user/group/view"><i class="fa fa-list"></i> Tất cả nhóm quyền</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-user-plus"></i> Xóa nhóm quyền</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <?php
            $redirect = base64_decode($this->input->get('redirect'));
            if (isset($num_member)) {
                //Con thanh vien trong nhom => khong cho xoa
                ?>
                <div class="notification error png_bg">
                    <div>
                        Còn <?php echo $num_member; ?> thành viên trong nhóm này. Hãy di chuyển thành viên sang nhóm khác và thử lại!
                    </div>
                </div>
                <a href="<?php echo $redirect; ?>"><button type="button" class="button">Quay lại</button></a>
            <?php } else {
                ?>
                <form action="" method="post">
                    <fieldset>
                        <div class="notification information png_bg">
                            <div>
                                Bạn có thực sự muốn xóa nhóm quyền "<?php echo isset($group['group_name']) ? $group['group_name'] : ''; ?>" không? <br/>Nhấn "Xác nhận" để xóa!
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