<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo base_url(); ?>">
        <title> Đăng nhập hệ thống</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/frontend/css/login.css'); ?>" media="all" />
        <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
        <link rel="stylesheet" href="<?php echo base_url('template/font-awesome/css/font-awesome.min.css'); ?>" type="text/css" media="screen" />
    </head>
    <body>

        <!-- Form Module-->
        <div class="module form-module">
            <div class="form">
                <h2>Đăng nhập hệ thống</h2>
                <?php
                    $message_flashdata = $this->session->flashdata('message_error');
                    if (isset($message_flashdata) && count($message_flashdata)) {
                        echo '<div class="error">';
                        echo $message_flashdata['message'];
                        echo'</div>';
                    }
                    echo validation_errors();
                ?>
                <form action="" method="POST">
                    <input type="text" name="email" placeholder="Email" required/>
                    <input type="password" name="password" placeholder="Mật khẩu" required/>
                    <button type="submit" name="submit">Đăng nhập</button>
                </form>
            </div>
            <div class="cta" style="display: none;"><a href="#">Forgot your password?</a></div>
        </div>


        <script type="text/javascript" src="<?php echo base_url('template/js/jquery.min.js'); ?>"></script>

    </body>
</html>
