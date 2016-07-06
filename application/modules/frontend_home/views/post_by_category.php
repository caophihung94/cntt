<div class="main-list">
    <div class="widget-title"><?php echo!empty($category_detail['cat_name']) ? htmlentities(stripslashes($category_detail['cat_name'])) : ''; ?></div>
    <?php if (!empty($list_posts) && is_array($list_posts)): ?>
        <?php foreach ($list_posts as $post): ?>
            <article>
                <div class="row">
                    <div class="col-sm-4">
                        <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>">
                            <img src="<?php echo!empty($post['post_image']) ? $post['post_image'] : 'template/frontend/images/default-banner.jpg'; ?>" class="img-thumbnail center-block thumbnail-post-by-category" alt="<?php echo htmlentities(stripslashes($post['post_name'])); ?>">
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="info">
                            <span>
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <time><?php echo date('d/m/Y', strtotime($post['updated'])); ?></time>
                            </span>
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <?php echo htmlentities(stripslashes($post['name'])); ?>
                            </span>

                        </div>
                        <h4>
                            <a href="<?php echo 'bai-viet/' . $post['post_slug'] . '-' . $post['post_id'] . '.html'; ?>"><?php echo htmlentities(stripslashes($post['post_name'])); ?></a>
                        </h4>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="row text-center">
        <!-- Pagination -->
        <?php echo !empty($paginator) ? $paginator : ''; ?>
    </div>
</div>