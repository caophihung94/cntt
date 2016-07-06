<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="icon">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </div>
                    <div class="text">
                        <h4>Giới thiệu</h4>
                        <div><?php echo!empty($setting['description']) ? $setting['description'] : ''; ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon">
                        <i class="fa fa-compass" aria-hidden="true"></i>
                    </div>
                    <div class="text">
                        <h4>Liên hệ</h4>
                        <div class="list">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> Địa chỉ: <?php echo!empty($setting['address']) ? $setting['address'] : ''; ?>
                        </div>
                        <div class="list">
                            <i class="fa fa-phone-square" aria-hidden="true"></i> Điện thoại: <?php echo!empty($setting['phone_number']) ? $setting['phone_number'] : ''; ?>
                        </div>
                        <div class="list">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i> Email: <?php echo!empty($setting['email']) ? $setting['email'] : ''; ?>
                        </div>
                        <div class="list">
                            <i class="fa fa-globe" aria-hidden="true"></i> Website: <?php echo!empty($setting['url']) ? $setting['url'] : ''; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </div>
                    <div class="text">
                        <h4>Liên kết</h4>
                        <div>
                            http://www.thanhdo.edu.vn
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer bottom-->

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <div class="copyright">
                        <span class="icon">
                            <i class="fa fa-copyright"></i>
                        </span>
                        2016 All Rights Reserved</div>
                </div>
                <div class="col-sm-6 text-center">
                    <div class="social">
                        <a href="<?php echo!empty($setting['facebook']) ? $setting['facebook'] : ''; ?>" class="fb">
                            <span class="icon"><i class="fa fa-facebook"></i></span>
                            <span class="info">
                                <span class="follow">Facebook</span>
                            </span>
                        </a>
                        <a href="<?php echo!empty($setting['twitter']) ? $setting['twitter'] : ''; ?>" class="tw">
                            <span class="icon"><i class="fa fa-twitter"></i></span>
                            <span class="info">
                                <span class="follow">Twitter</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6&appId=181469048859295";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>