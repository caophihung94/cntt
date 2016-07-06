<h2>Quản lí nhóm quyền</h2>
<div class="clear"></div> 
<div class="content-box">
    <div class="content-box-header">
        <h3>Sửa nhóm quyền</h3>
        <ul class="content-box-tabs">
            <li><a href="backend_user/group/view"><i class="fa fa-list"></i> Tất cả nhóm quyền</a></li>
            <li><a href="#" class="default-tab current"><i class="fa fa-user-md"></i> Sửa nhóm quyền</a></li>
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
                <fieldset>
                    <p>
                        <label>Tên nhóm quyền</label>
                        <input class="text-input medium-input" type="text" name="name" value="<?php echo!empty($group['group_name']) ? $group['group_name'] : ''; ?>" required>
                        <?php echo form_error('name', '<span class="input-notification error png_bg">', '</span>'); ?>
                    </p>

                    <p>
                        <label>Quyền hạn:</label>
                        <?php
                        $dir = 'application/modules';
                        $folder = scandir($dir);
                        if (isset($folder) && is_array($folder) && count($folder)) {
                            foreach ($folder as $keyFolder => $valFolder) {
                                if (in_array($valFolder, array('.', '..')))
                                    continue;
                                $module = substr($valFolder, 0, 8);
                                if ($module != 'backend_')
                                    continue;
                                if (file_exists($dir . '/' . $valFolder . '/config.xml') && trim(file_get_contents($dir . '/' . $valFolder . '/config.xml')) != NULL) {
                                    $xml = simplexml_load_file($dir . '/' . $valFolder . '/config.xml');
                                    $xml = json_decode(json_encode((array) $xml), TRUE);
                                    if (!empty($xml['permissions']) && is_array($xml['permissions'])) {
                                        if (array_key_exists('title', $xml['permissions'])) {
                                            ?>
                                        <div class="well">
                                            <h5><?php echo $xml['permissions']['title']; ?></h5>
                                            <div class="ln_solid"></div>
                                            <?php
                                            if (!empty($xml['permissions']['item']) && is_array($xml['permissions']['item'])) {
                                                if (!isset($permissions_post)) {
                                                    $permissions_post = $this->input->post('permissions');
                                                }
                                                foreach ($xml['permissions']['item'] as $keyItem => $valItem) {
                                                    ?>
                                                    <input type="checkbox" name="permissions[]" value="<?php echo $valItem['param']; ?>" <?php echo (isset($permissions_post) && is_array($permissions_post) && in_array($valItem['param'], $permissions_post)) ? 'checked="checked"' : ''; ?>><?php echo $valItem['description']; ?>  &emsp;
                                                <?php } ?>
                                            <?php } ?>
                                        </div>	
                                        <?php
                                    } else {
                                        foreach ($xml['permissions'] as $keyPermissions => $valPermissions) {
                                            ?>
                                            <div class="well">
                                                <h6><?php echo $valPermissions['title']; ?></h6>
                                                <div class="ln_solid"></div>
                                                <?php
                                                if (isset($valPermissions['item']) && is_array($valPermissions['item']) && count($valPermissions['item'])) {
                                                    if (!isset($permissions_post)) {
                                                        $permissions_post = $this->input->post('permissions');
                                                    }
                                                    foreach ($valPermissions['item'] as $keyItem => $valItem) {
                                                        ?>
                                                        <input type="checkbox" name="permissions[]" value="<?php echo $valItem['param']; ?>" <?php echo (isset($permissions_post) && is_array($permissions_post) && in_array($valItem['param'], $permissions_post)) ? 'checked="checked"' : ''; ?>><?php echo $valItem['description']; ?>  &emsp;
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>	
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    </p>
                    <p>
                        <button type="reset" class="button">Làm lại</button>
                        <button type="submit" class="button" name="submit" />Cập nhật</button>
                    </p>
                </fieldset>
            </form>
        </div> <!-- End #tab1 -->
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<div class="clear"></div>