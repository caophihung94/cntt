<div class="main-list">
    <section class="post-container">
        <?php if (!empty($breadcrumb) && is_array($breadcrumb)): ?>
            <ol class="breadcrumb breadcrumb-arrow">
                <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a></li>
                <?php foreach ($breadcrumb as $val): ?>
                <li><a href="<?php echo 'chuyen-muc/' . $val['slug'] . '-' . $val['id']; ?>"><?php echo htmlentities(stripslashes($val['cat_name'])); ?></a></li>
                <?php endforeach; ?>
                <li class="active"><span><?php echo htmlentities(stripslashes($post_detail['post_name'])); ?></li>
            </ol>
        <?php endif; ?>

        <article>
            <h3 class="entry-title"><?php echo htmlentities(stripslashes($post_detail['post_name'])); ?></h3>
            <div class="info-line">
                <span>
                    <time datetime="<?php echo $post_detail['updated'] ?>" itemprop="datePublished">
                        <i class="fa fa-clock-o"></i> 
                        <?php echo date('d/m/Y', strtotime($post_detail['updated'])); ?>
                    </time>
                </span>
                <span itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
                    <i class="fa fa-user"></i> <?php echo htmlentities(stripslashes($post_detail['name'])); ?>
                </span>
                <span>
                    <?php if (!empty($_SESSION['authentication']['permission']) && is_array($_SESSION['authentication']['permission']) && in_array('backend_post/post/edit', $_SESSION['authentication']['permission'])): ?>
                        <a href="<?php echo 'backend_post/post/edit/' . $post_detail['post_id']; ?>" title="Sửa">
                            [ <i class="fa fa-pencil" aria-hidden="true"></i> ]
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['authentication']['permission']) && is_array($_SESSION['authentication']['permission']) && in_array('backend_post/post/del', $_SESSION['authentication']['permission'])): ?>
                        <a href="<?php echo 'backend_post/post/del/' . $post_detail['post_id']; ?>" title="Xóa">
                            [ <i class="fa fa-trash-o" aria-hidden="true"></i> ]
                        </a>
                    <?php endif; ?>
                </span>
            </div>
            <hr>
            <div class="entry-content">
                <p><?php echo!empty($post_detail['post_description']) ? htmlentities(stripslashes($post_detail['post_description'])) : ''; ?></p>

                <?php if (!empty($post_detail['post_image'])): ?>
                    <figure class="figure text-center">
                        <img src="<?php echo $post_detail['post_image']; ?>" class="figure-img img-fluid" alt="<?php echo htmlentities(stripslashes($post_detail['post_name'])); ?>" title="<?php echo htmlentities(stripslashes($post_detail['post_name'])); ?>">
                        <figcaption class="figure-caption text-center"><?php echo htmlentities(stripslashes($post_detail['post_name'])); ?></figcaption>
                    </figure>
                <?php endif; ?>

                <?php echo stripslashes($post_detail['post_content']); ?>
                <hr>
                <h4 class="heading">Cùng chuyên mục</h4>
                <ul>
                    <?php if (!empty($related_posts) && is_array($related_posts)): ?>
                        <?php foreach ($related_posts as $related_post): ?>
                            <li>
                                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                <a href="<?php echo 'bai-viet/' . $related_post['post_slug'] . '-' . $related_post['post_id'] . '.html'; ?>">
                                    <?php echo htmlentities(stripslashes($related_post['post_name'])); ?>
                                </a>
                                <span class="date"> (<?php echo date('d/m/Y', strtotime($related_post['updated'])); ?>)</span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </article>
    </section>
</div>