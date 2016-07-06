<h2>Quản lí bài viết</h2>
<div class="clear"></div>
<div class="content-box">
    <div class="content-box-header">
        <h3>Bộ lọc</h3>
        <div class="clear"></div>
    </div> <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab">
            <form action="" method="get" name="filter">
                <span>
                    <?php
                    $status = (isset($_GET['status'])) ? ($_GET['status']) : NULL;
                    echo form_dropdown('status', ['' => '', '0' => 'Lưu nháp', '1' => 'Đã xuất bản'], $status, 'class="text-input small-input"');
                    ?>
                </span>
                <span>
                    <?php
                    $hot = (isset($_GET['hot'])) ? ($_GET['hot']) : 0;
                    echo form_dropdown('hot', ['' => '', '1' => 'Bài viết nổi bật', '0' => 'Bình thường'], $hot, 'class="text-input small-input"');
                    ?>
                </span>
                <span>
                    <button type="submit" name="filter" class="button">Lọc</button>
                </span>
            </form>
        </div>
    </div>
</div>
<div class="content-box">
    <div class="content-box-header">
        <h3>Tất cả bài viết</h3>
        <ul class="content-box-tabs">
            <li><a href="#" class="default-tab current"><i class="fa fa-list"></i> Danh sách bài viết</a></li>
            <li><a href="backend_post/post/add"><i class="fa fa-plus"></i> Thêm bài viết</a></li>
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
                            <th>Tên bài viết</th>
                            <th>Danh mục</th>
                            <th>Người đăng</th>
                            <th>Trạng thái</th>
                            <th>Nổi bật</th>
                            <th><p align="center">Thao tác</p></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($list_post) && is_array($list_post) && count($list_post)) {
                            foreach ($list_post as $key => $val) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox[]" value="<?php echo $val['post_id']; ?>"/></td>
                                    <td><?php echo stripslashes($val['post_name']); ?></td>
                                    <td><?php echo stripslashes($val['cat_name']); ?></td>
                                    <td><?php echo stripslashes($val['name']); ?></td>
                                    <td>
                                        <?php
                                        if ($val['post_status'] == 0) {
                                            echo 'Lưu nháp';
                                        } elseif ($val['post_status'] == 1) {
                                            echo 'Đã xuất bản';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($val['post_feature'] == 0) {
                                            echo 'Không';
                                        } elseif ($val['post_feature'] == 1) {
                                            echo 'Có';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <p align="center">
                                            <a href="<?php echo base_url() . 'backend_post/post/edit/' . $val['post_id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Sửa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/pencil.png" alt="Edit" /></a>
                                            <a href="<?php echo base_url() . 'backend_post/post/del/' . $val['post_id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Xóa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/cross.png" alt="Delete" /></a> 
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