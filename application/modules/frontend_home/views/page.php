<div class="main-list">
    <section class="post-container">
        <article>
            <h3 class="entry-title"><?php echo htmlentities(stripslashes($page_detail['page_name'])); ?></h3>
            <?php if (!empty($_SESSION['authentication']['permission']) && is_array($_SESSION['authentication']['permission']) && in_array('backend_menu/page/edit', $_SESSION['authentication']['permission'])): ?>
                <a href="<?php echo 'backend_menu/page/edit/' . $page_detail['id']; ?>" title="Sửa">
                    [ <i class="fa fa-pencil" aria-hidden="true"></i> ]
                </a>
            <?php endif; ?>
            <?php if (!empty($_SESSION['authentication']['permission']) && is_array($_SESSION['authentication']['permission']) && in_array('backend_menu/page/del', $_SESSION['authentication']['permission'])): ?>
                <a href="<?php echo 'backend_menu/page/del/' . $page_detail['id']; ?>" title="Xóa">
                    [ <i class="fa fa-trash-o" aria-hidden="true"></i> ]
                </a>
            <?php endif; ?>
            <hr>
            <div class="entry-content">
                <p><?php echo!empty($page_detail['page_description']) ? htmlentities(stripslashes($page_detail['page_description'])) : ''; ?></p>

                <?php if (!empty($page_detail['page_image'])): ?>
                    <figure class="figure text-center">
                        <img src="<?php echo $page_detail['page_image']; ?>" class="figure-img img-fluid" alt="<?php echo htmlentities(stripslashes($page_detail['page_name'])); ?>" title="<?php echo htmlentities(stripslashes($page_detail['page_name'])); ?>">
                        <figcaption class="figure-caption text-center"><?php echo htmlentities(stripslashes($page_detail['page_name'])); ?></figcaption>
                    </figure>
                <?php endif; ?>

                <?php echo stripslashes($page_detail['page_content']); ?>
            </div>
        </article>
    </section>
</div>