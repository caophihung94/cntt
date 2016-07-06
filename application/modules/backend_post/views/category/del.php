<!-- Page Head -->
<h2>Quản lí danh mục</h2>
<div class="clear"></div> <!-- End .clear -->
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3>Xóa danh mục</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_post/category/view"><i class="fa fa-list"></i> Tất cả danh mục</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-trash-o"></i> Xóa danh mục</a></li>
        </ul>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <?php
            $redirect = base64_decode($this->input->get('redirect'));
            if (isset($num_post)) {
                //Con bai viet trong chuyen muc => khong cho xoa
                ?>
                <div class="notification error png_bg">
                    <div>
                        Còn <?php echo $num_post; ?> tài liệu trong danh mục này. Hãy di chuyển tất cả tài liệu sang danh mục khác và thử lại!
                    </div>
                </div>
                <a href="<?php echo $redirect; ?>"><button type="button" class="button">Quay lại</button></a>
            <?php } elseif(isset($num_subCategory)){
                //Con danh muc con => khong cho xoa
                ?>
                <div class="notification error png_bg">
                    <div>
                        Còn <?php echo $num_subCategory; ?> danh mục con trong danh mục này. Hãy di chuyển tất cả danh mục con sang danh mục khác và thử lại!
                    </div>
                </div>
                <a href="<?php echo $redirect; ?>"><button type="button" class="button">Quay lại</button></a>
           <?php }else {
                ?>
                <form action="" method="post">
                    <fieldset>
                        <div class="notification information png_bg">
                            <div>
                                Bạn có thực sự muốn xóa danh mục "<?php echo isset($category['cat_name']) ? $category['cat_name'] : ''; ?>" không? <br/>Nhấn "Xác nhận" để xóa!
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
