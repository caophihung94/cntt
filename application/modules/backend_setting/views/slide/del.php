<!-- Page Head -->
<h2>Quản lí slide</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Xóa ảnh</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_setting/slide/view"><i class="fa fa-list"></i> Danh sách ảnh</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-trash-o"></i> Xóa ảnh</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <?php $redirect = base64_decode($this->input->get('redirect')); ?>
            <form action="" method="post">
                <fieldset>
                    <div class="notification information png_bg">
                        <div>
                            Bạn có thực sự muốn xóa ảnh này không? <br/>Nhấn "Xác nhận" để xóa!
                        </div>
                    </div>
                    <p>
                        <a href="<?php echo $redirect; ?>"><button type="button" class="button">Quay lại</button></a>
                        <input class="button" type="submit" name="submit" value="Xác nhận" />
                    </p>
                </fieldset>
                <div class="clear"></div><!-- End .clear -->
            </form>
        </div> <!-- End #tab2 -->        
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>