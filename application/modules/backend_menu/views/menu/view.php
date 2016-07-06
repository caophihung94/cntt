<h2>Quản lí menu</h2>
<div class="clear"></div>
<div class="content-box">
    <div class="content-box-header">
        <h3>Tất cả menu</h3>
        <ul class="content-box-tabs">
            <li><a href="#" class="default-tab current"><i class="fa fa-list"></i> Danh sách menu</a></li>
            <li><a href="backend_menu/menu/add"><i class="fa fa-plus"></i> Thêm menu</a></li>
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
                            <th>Tên menu</th>
                            <th>Vị trí</th>
                            <th><p align="center">Thao tác</p></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($list_menu) && is_array($list_menu) && count($list_menu)) {
                            foreach ($list_menu as $key => $val) {
                                ?>
                                <tr>
                                    <td><?php echo stripslashes($val['menu_name']); ?></td>
                                    <td><?php echo $val['menu_position']; ?></td>
                                    <td>
                                        <p align="center">
                                            <a href="<?php echo base_url() . 'backend_menu/menu/edit/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Sửa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/pencil.png" alt="Edit" /></a>
                                            <a href="<?php echo base_url() . 'backend_menu/menu/del/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Xóa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/cross.png" alt="Delete" /></a> 
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
