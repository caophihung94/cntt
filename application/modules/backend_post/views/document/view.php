<h2>Quản lí đồ án</h2>
<div class="content-box">
    <div class="content-box-header">
        <h3>Tất cả đồ án</h3>
        <ul class="content-box-tabs">
            <li><a href="#" class="default-tab current"><i class="fa fa-list"></i> Danh sách đồ án</a></li>
            <li><a href="backend_post/document/add"><i class="fa fa-plus"></i> Thêm đồ án</a></li>
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
                            <th>Tên đề tài</th>
                            <th>Tác giả</th>
                            <th>Nổi bật</th>
                            <th>Trạng thái</th>
                            <th><p align="center">Thao tác</p></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($list_document) && is_array($list_document) && count($list_document)) {
                            foreach ($list_document as $key => $val) {
                                ?>
                                <tr>
                                    <td><?php echo stripslashes($val['doc_name']); ?></td>
                                    <td><?php echo stripslashes($val['doc_author']); ?></td>
                                    <td> <?php echo $val['doc_feature'] == 0 ? 'Không' : 'Có'; ?></td>
                                    <td> <?php echo $val['doc_status'] == 0 ? 'Lưu nháp' : 'Đã xuất bản'; ?></td>
                                    <td>
                                        <p align="center">
                                            <a href="<?php echo base_url() . 'backend_post/document/edit/' . $val['doc_id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Sửa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/pencil.png" alt="Edit" /></a>
                                            <a href="<?php echo base_url() . 'backend_post/document/del/' . $val['doc_id'] . '?redirect=' . base64_encode($this->lb_string->url_origin()); ?>" title="Xóa"><img src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/icons/cross.png" alt="Delete" /></a> 
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
                            <td colspan="12">
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