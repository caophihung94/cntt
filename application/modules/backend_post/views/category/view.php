<h2>Quản lí danh mục</h2>
<div class="clear"></div> 
<div class="content-box">
    <div class="content-box-header">
        <h3>Danh sách danh mục</h3>
        <ul class="content-box-tabs">
            <li><a href="#" class="default-tab current"><i class="fa fa-list"></i> Danh sách danh mục</a></li>
            <li><a href="backend_post/category/add"><i class="fa fa-plus"></i> Thêm danh mục</a></li>
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
                            <th>Danh mục</th>
                            <th><p align="center">Xuất bản</p></th>
                            <th><p align="center">Thao tác</p></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($list_category) && is_array($list_category) && count($list_category)) {
                            foreach ($list_category as $key => $val) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>"/></td>
                                    <td>
                                        <?php
                                        if (!empty($val['breadcrumb']) && is_array($val['breadcrumb'])) {
                                            foreach ($val['breadcrumb'] as $keyBreadcrumb => $valBreadcrumb) {
                                                echo '<span class="breadcrumb">' . htmlentities($valBreadcrumb['cat_name']) . '</span>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><p align="center"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/resources/images/icons/<?php echo ($val['publish'] == 1) ? 'tick_circle' : 'cross_circle'; ?>.png"></p></td>
                                    <td>
                                        <p align="center">
                                            <a href="<?php echo base_url() . 'backend_post/category/edit/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Sửa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/pencil.png" alt="Edit" /></a>
                                            <a href="<?php echo base_url() . 'backend_post/category/del/' . $val['id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Xóa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/cross.png" alt="Delete" /></a> 
                                        </p>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="4">Không có dữ liệu</td></tr>';
                        }
                        ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="bulk-actions align-left">
                                    <select name="action" id="select_action">
                                        <option value="">Chọn một hành động...</option>
                                        <option value="delete">Xóa</option>
                                        <option value="publish">Xuất bản</option>
                                        <option value="unpublish">Bỏ xuất bản</option>
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