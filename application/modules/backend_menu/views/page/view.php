<h2>Quản lí trang</h2>
<div class="clear"></div>
<div class="content-box">
    <div class="content-box-header">
        <h3>Tất cả trang</h3>
        <ul class="content-box-tabs">
            <li><a href="#" class="default-tab current"><i class="fa fa-list"></i> Danh sách trang</a></li>
            <li><a href="backend_menu/page/add"><i class="fa fa-plus"></i> Thêm trang</a></li>
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
                <table>
                    <thead>
                        <tr>
                            <th>Tên trang</th>
                            <th>Vị trí</th>
                            <th><p align="center">Thao tác</p></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($list_page) && is_array($list_page) && count($list_page)) {
                            foreach ($list_page as $key => $val) {
                                ?>
                                <tr>
                                    <td><?php echo stripslashes($val['page_name']); ?></td>
                                    <td><?php echo $val['page_position']; ?></td>
                                    <td>
                                        <p align="center">
                                            <a href="<?php echo base_url() . 'backend_menu/page/edit/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Sửa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/pencil.png" alt="Edit" /></a>
                                            <a href="<?php echo base_url() . 'backend_menu/page/del/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Xóa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/cross.png" alt="Delete" /></a> 
                                        </p>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="9">Không có dữ liệu</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div> <!-- End #tab1 -->
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>
