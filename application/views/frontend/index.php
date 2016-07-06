<!DOCTYPE html>
<html>
    <!-- head -->
    <?php $this->load->view('frontend/head'); ?>
    <!-- end head -->
    <body>
        
        <div class="container text-center">
            <div class="banner">
                <img src="<?php echo !empty($setting['banner']) ? base_url($setting['banner']) : ''; ?>">
            </div>
        </div>
        <!-- Navigation -->
        <?php $this->load->view('frontend/nav'); ?>
        <!-- end Navigation -->
        <!-- Slide -->
        <?php $this->load->view('frontend/slide'); ?>
        <!-- end Slide -->

        <!-- Page Content -->
        <main>
            <div class="container">
                <section class="row previews">
                    <div class="col-md-8">
                        <!-- Main list -->
                        <?php isset($template) ? $this->load->view($template) : NULL; ?>
                        <!-- end Main list -->
                    </div>
                    <div class="col-md-4">
                        <!-- Sidebar -->
                        <?php $this->load->view('frontend/sidebar'); ?>
                        <!-- end Sidebar -->
                    </div>
                    <div class="clearfix"> </div>
                </section>
            </div>
        </main>
        <!-- Footer -->
        <?php $this->load->view('frontend/footer'); ?>
        <!-- end Footer -->

        <!-- Modal Search -->
        <?php $this->load->view('frontend/modalSearch'); ?>
        <!-- end Modal Search -->

        <!-- JavaScript -->
        <script src="template/bootstrap/js/bootstrap.min.js"></script>
        <script src="template/frontend/js/my-script.js"></script>
        <!-- SmartMenus -->
        <link rel="stylesheet" href="template/smartmenus/jquery.smartmenus.bootstrap.css">
        <script src="template/smartmenus/jquery.smartmenus.min.js"></script>
        <script src="template/smartmenus/jquery.smartmenus.bootstrap.min.js"></script>
        <!-- bxSlider Javascript file -->
        <script src="template/bxslider/jquery.bxslider.min.js"></script>
        <!-- bxSlider CSS file -->
        <link href="template/bxslider/jquery.bxslider.css" rel="stylesheet" />

    </body>
</html>