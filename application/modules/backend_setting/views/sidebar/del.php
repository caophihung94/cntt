<!-- Page Head -->
<h2>Quản lí sidebar</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Xóa phần tử</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_setting/sidebar/view"><i class="fa fa-list"></i> Danh sách phần tử</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-trash-o"></i> Xóa phần tử</a></li>
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
                            Bạn có thực sự muốn xóa trang "<?php echo isset($block['description']) ? $block['description'] : ''; ?>" không? <br/>Nhấn "Xác nhận" để xóa!
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