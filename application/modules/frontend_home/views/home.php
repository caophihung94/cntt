<div class="main-list">
    <?php if (!empty($dataCategories) && is_array($dataCategories)): ?>
        <?php foreach ($dataCategories as $keyCategory => $dataCategory): ?>
            <div class="col-md-6">
                <?php if (!empty($dataCategory['category'])):; ?>
                    <div class="widget-title">
                        <h3 class="text-center">
                            <a href="<?php echo 'chuyen-muc/' . $dataCategory['category']['slug'] . '-' . $dataCategory['category']['id']; ?>" title="TIN TỨC - SỰ KIỆN">
                                <?php echo stripslashes($dataCategory['category']['cat_name']); ?>
                            </a>
                        </h3>
                    </div>
                <?php endif; ?>
                <ul>
                    <?php if (!empty($dataCategory['posts'])): ?>
                        <?php foreach ($dataCategory['posts'] as $key => $post): ?>
                            <?php if ($key == 0): ?>
                                <li><!--begin colum item-->
                                    <div class="thumbnail-first-post">
                                    <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>" title="<?php stripslashes($post['post_name']); ?>">
                                        <img class="img-thumbnail" src="<?php echo!empty($post['post_image']) ? $post['post_image'] : 'template/frontend/images/default-banner.jpg'; ?>" >
                                    </a>
                                    </div>
                                    <div class="clearfix"></div><br>
                                    <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>">
                                        <strong><?php echo htmlentities(stripslashes($post['post_name'])); ?></strong>
                                    </a>
                                    <span class="date"> (<?php echo date('d/m/Y', strtotime($post['updated'])); ?>)</span>
                                </li>
                            <?php else: ?>
                                <li>
                                    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                    <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>"><?php echo stripslashes($post['post_name']); ?></a>
                                    <span class="date"> (<?php echo date('d/m/Y', strtotime($post['updated'])); ?>)</span>
                                </li>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php else: ?>
                        Chưa có bài viết nào trong chuyên mục này!
                    <?php endif; ?>
                </ul>
                <div class="pull-right">
                    <b>
                        <a href="<?php echo 'chuyen-muc/' . $dataCategory['category']['slug'] . '-' . $dataCategory['category']['id']; ?>">
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            Xem tất cả
                        </a>
                    </b>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php if (($keyCategory + 1) % 2 == 0) echo '<div class="clearfix"></div>'; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>