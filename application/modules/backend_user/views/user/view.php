<h2>Quản lí thành viên</h2>
<div class="clear"></div> 
<div class="content-box">
    <div class="content-box-header">
        <h3>Danh sách thành viên</h3>
        <ul class="content-box-tabs">
            <li><a href="#" class="default-tab current"><i class="fa fa-user"></i> Tất cả thành viên</a></li>
            <li><a href="backend_user/user/add"><i class="fa fa-user-plus"></i> Thêm thành viên</a></li>
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
                            <th><input class="check-all" type="checkbox" /></th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Nhóm</th>
                            <th><p align="center">Trạng thái</p></th>
                            <th><p align="center">Thao tác</p></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($user) && is_array($user) && count($user)) {
                            foreach ($user as $key => $val) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>"/></td>
                                    <td class=" "><?php echo $val['name']; ?></td>
                                    <td class=" "><?php echo $val['email']; ?></td>
                                    <td class=" "><?php echo $val['group_name']; ?></td>
                                    <td><p align="center"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/resources/images/icons/<?php echo ($val['status'] == 1) ? 'tick_circle' : 'cross_circle'; ?>.png"></p></td>
                                    <td>
                                        <p align="center">
                                            <a href="<?php echo base_url() . 'backend_user/user/edit/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Sửa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/pencil.png" alt="Edit" /></a>
                                            <a href="<?php echo base_url() . 'backend_user/user/del/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Xóa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/cross.png" alt="Delete" /></a> 
                                        </p>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="6">Không có dữ liệu</td></tr>';
                        }
                        ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="bulk-actions align-left">
                                    <select name="action" id="select_action">
                                        <option value="">Chọn một hành động...</option>
                                        <option value="active">Kích hoạt</option>
                                        <option value="banned">Cấm</option>
                                        <option value="delete">Xóa</option>
                                    </select>
                                    <a class="button" id="apply">Xác nhận</a>
                                    <div style="display:none"><input type="submit" name="submit" id="submit"/></div>
                                </div>
                                <!--Phan trang-->
                                <?php echo $paginator; ?>
                                <div class="clear"></div>
                            </td>
                        </tr>
                    </tfoot>

                </table>
            </form>
        </div> <!-- End #tab1 -->
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>
<script>
    $(document).ready(function () {
        $('#apply').click(function () {
            if ($('#select_action').val() == 'delete') {
                var flag = confirm('Bạn có thực sự muốn xóa các lựa chọn không?');
                if (flag == true) {
                    $('#submit').click();
                }
            } else {
                $('#submit').click();
            }
            return false;
        });
    });
</script>