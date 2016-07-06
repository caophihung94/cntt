<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo isset($meta_title) ? htmlentities($meta_title) : ''; ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/backend/simplaAdmin/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/backend/simplaAdmin/css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/backend/simplaAdmin/css/invalid.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url(); ?>template/backend/simplaAdmin/scripts/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>template/backend/simplaAdmin/scripts/simpla.jquery.configuration.js"></script>
    </head>

    <body id="login">
        <div id="login-wrapper" class="png_bg">
            <div id="login-top">
                <h1>Admin Panel</h1>
                <!-- Logo (221px width) -->
                <img id="logo" src="<?php echo base_url(); ?>template/backend/simplaAdmin/images/logo.png" alt="Admin logo" />
            </div> <!-- End #logn-top -->

            <?php
                if (isset($template) && !empty($template)) {
                    $this->load->view($template, isset($data) ? $data : NULL);
                }
            ?>

        </div> <!-- End #login-wrapper -->
    </body>
</html>
