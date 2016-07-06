<header class="sb-page-header">
    <div class="container">
        <section class="row previews">
            <div class="col-md-8 text-center">
                <?php if (!empty($slide) && is_array($slide)): ?>
                    <ul class="bxslider">
                        <?php foreach ($slide as $item_slide): ?>
                            <li>
                                <?php if (!empty($item_slide['link'])): ?>
                                    <a href="<?php echo $item_slide['link']; ?>">
                                        <img src="<?php echo base_url($item_slide['image']); ?>" title="<?php echo!empty($item_slide['caption']) ? $item_slide['caption'] : ''; ?>" />
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo base_url($item_slide['image']); ?>" title="<?php echo!empty($item_slide['caption']) ? $item_slide['caption'] : ''; ?>"/>
                                <?php endif; ?>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <ul class="bxslider">
                        <li><img src="template/frontend/images/thanh-do-banner-1.jpg" /></li>
                        <li><img src="template/frontend/images/thanh-do-banner-2.jpg" /></li>
                        <li><img src="template/frontend/images/thanh-do-banner-3.jpg" /></li>
                        <li><img src="template/frontend/images/thanh-do-banner-4.jpg" /></li>
                        <li><img src="template/frontend/images/thanh-do-banner-5.jpg" /></li>
                    </ul>
                <?php endif; ?>

            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    <div class="widget">
                        <div class="widget-title">Nổi bật</div>
                        <div class="tab-content">
                            <div id="random" class="tab-pane fade in active" itemscope="itemscope" itemtype="http://schema.org/Thing">
                                <ul>
                                    <?php if (!empty($post_feature) && is_array($post_feature)): ?>
                                        <?php foreach ($post_feature as $post): ?>
                                            <li>
                                                <div class="image-thumnail">
                                                    <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>">
                                                        <img itemprop="image" class="img-thumbnail" src="<?php echo!empty($post['post_image']) ? $post['post_image'] : 'template/frontend/images/default-logo.jpg'; ?>" alt="<?php htmlentities(stripslashes($post['post_name'])); ?>" title="<?php htmlentities(stripslashes($post['post_name'])) ?>">
                                                    </a>
                                                </div>
                                                <div class="post-title-sidebar">
                                                    <h5 itemprop="name">
                                                        <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>">
                                                            <?php echo htmlentities(stripslashes($post['post_name'])); ?>
                                                        </a>
                                                    </h5>
                                                    <p style="color: #333;"><i class="fa fa-calendar-o"></i> <time><?php echo date('d/m/Y', strtotime($post['updated'])); ?></time></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</header>