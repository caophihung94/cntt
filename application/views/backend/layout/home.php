<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <base href="<?php echo base_url(); ?>">
        <title><?php echo isset($meta_title) ? htmlentities($meta_title) : ''; ?></title>
        <link rel="stylesheet" href="<?php echo base_url('template/backend/simplaAdmin/css/reset.css'); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url('template/backend/simplaAdmin/css/style.css'); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url('template/font-awesome/css/font-awesome.min.css'); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url('template/backend/simplaAdmin/css/invalid.css'); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url('template/fancybox/source/jquery.fancybox.css'); ?>" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url('template/js/jquery.min.js'); ?>"></script>
    </head>
    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
            <div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
                    <h1 id="sidebar-title"><a href="#">Admin Panel</a></h1>
                    <a href="#"><img id="logo" src="<?php echo base_url('template/backend/simplaAdmin/images/logo.png'); ?>" alt="Simpla Admin logo" /></a>
                    <div id="profile-links">
                        <?php
                        if (isset($authentication['name'])) {
                            echo "Xin chào " . $authentication['name'] . "<br/>";
                        }
                        ?>
                        <a href="<?php echo base_url(); ?>" title="Xem ngoài trang">Trang chủ</a> | <a href="<?php echo base_url('logout'); ?>" title="Sign Out">Đăng xuất</a>
                    </div>
                    <ul id="main-nav">  <!-- Accordion Menu -->
                        <li> 
                            <a href="#" class="nav-top-item <?php
                            if ($this->uri->segment(2) == 'post') {
                                echo 'current';
                            }
                            ?>">Tin tức</a>
                            <ul>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'add_post') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_post/post/add'); ?>">Thêm bài viết</a>
                                </li>

                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'view_post') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_post/post/view'); ?>">Danh sách bài viết</a>
                                </li>
                            </ul>
                        </li>
                        <li> 
                            <a href="#" class="nav-top-item <?php
                            if ($this->uri->segment(2) == 'category') {
                                echo 'current';
                            }
                            ?>">Danh mục tin</a>
                            <ul>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'add_category') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_post/category/add'); ?>">Thêm danh mục mới</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'view_category') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_post/category/view'); ?>">Danh sách danh mục</a>
                                </li>
                            </ul>
                        </li>
                        <li> 
                            <a href="#" class="nav-top-item <?php
                            if ($this->uri->segment(1) == 'backend_menu') {
                                echo 'current';
                            }
                            ?>">Menu</a>
                            <ul>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'menu') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_menu/menu/view'); ?>">Danh mục menu</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'page') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_menu/page/view'); ?>">Danh sách trang</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li> 
                            <a href="#" class="nav-top-item <?php
                            if ($this->uri->segment(2) == 'document') {
                                echo 'current';
                            }
                            ?>">Đồ án</a>
                            <ul>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'add_document') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_post/document/add'); ?>">Thêm đồ án</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'view_document') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_post/document/view'); ?>">Danh sách đồ án</a>
                                </li>
                            </ul>
                        </li>

                        <li> 
                            <a href="#" class="nav-top-item <?php
                            if ($this->uri->segment(1) == 'backend_user') {
                                echo 'current';
                            }
                            ?>">Thành viên</a>
                            <ul>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'view_user') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_user/user/view'); ?>">Quản lí thành viên</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'view_group') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_user/group/view'); ?>">Quản lí nhóm quyền</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'update_profile') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_user/user/update_profile'); ?>">Cập nhật hồ sơ cá nhân</a>
                                </li>
                            </ul>
                        </li>

                        <li> 
                            <a href="#" class="nav-top-item <?php
                            if ($this->uri->segment(1) == 'backend_setting') {
                                echo 'current';
                            }
                            ?>">Cài đặt</a>
                            <ul>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'setting') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_setting/setting'); ?>">Cài đặt trang web</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'slide') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_setting/slide/view'); ?>">Quản lí slide</a>
                                </li>
                                <li>
                                    <a <?php
                                    if (isset($active) && $active == 'sidebar') {
                                        echo 'class="current"';
                                    }
                                    ?> href="<?php echo base_url('backend_setting/sidebar/view'); ?>">Quản lí sidebar</a>
                                </li>
                            </ul>
                        </li>
                    </ul> <!-- End #main-nav -->

                </div>
            </div> <!-- End #sidebar -->

            <div id="main-content"> <!-- Main Content Section with everything -->
                <noscript>
                <div class="notification error png_bg">
                    <div>
                        Javascript bị tắt hoặc trình duyệt không hỗ trợ.</div>
                </div>
                </noscript>
                <?php
                if (isset($template) && !empty($template)) {
                    $this->load->view($template, isset($data) ? $data : NULL);
                }
                ?> 
                <div id="footer">
                    <small>
                        &#169; Copyright <?php echo date("Y"); ?> AnythingVN.Com | Powered by Cao Phi Hùng | <a href="#">Top</a>
                    </small>
                </div><!-- End #footer -->
            </div> <!-- End #main-content -->	
        </div>
        <script type="text/javascript" src="<?php echo base_url('template/backend/simplaAdmin/resources/scripts/simpla.jquery.configuration.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('template/fancybox/source/jquery.fancybox.pack.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('template/backend/simplaAdmin/resources/scripts/slugify.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('template/backend/simplaAdmin/resources/scripts/my-script.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('editor/tinymce/tinymce.min.js'); ?>"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: ".textarea",
                plugins: "autoresize",
                theme: "modern",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern imagetools codesample responsivefilemanager"
                ],
                        toolbar1: "insertfile undo redo | styleselect | bold italic underline removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                toolbar2: "print preview | forecolor backcolor | emoticons | link unlink anchor | image media| responsivefilemanager | code codesample",
                image_caption: true,
                media_live_embeds: true,
                imagetools_cors_hosts: ['tinymce.com', 'codepen.io'],
                image_advtab: true,
                relative_urls: false,
                external_filemanager_path: "<?php echo base_url() . "filemanager/"; ?>",
                filemanager_title: "Quản lí file",
                filemanager_access_key:'ckasbvbazk30-0647290zlngfv07lsjxsin',
                external_plugins: {"filemanager": "<?php echo base_url('filemanager/plugin.min.js'); ?>"},
                height: 400
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".iframe-btn").fancybox({
                    type: 'iframe',
                    width: '80%',
                    height: '80%',
                    autoSize: false,
                });
            });
        </script>
    </body>
</html>