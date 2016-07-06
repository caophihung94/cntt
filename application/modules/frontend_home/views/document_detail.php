<div class="main-list">
    <section class="post-container">
        <ol class="breadcrumb breadcrumb-arrow">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?php echo base_url('do-an-tot-nghiep'); ?>">Đồ án</a></li>
            <li class="active"><span><?php echo htmlentities(stripslashes($document_detail['doc_name'])); ?></li>
        </ol>

        <article>
            <h3 class="entry-title"><?php echo htmlentities(stripslashes($document_detail['doc_name'])); ?></h3>
            <div class="info-line">
                <span>
                    <time datetime="<?php echo $document_detail['updated'] ?>" itemprop="datePublished">
                        <i class="fa fa-clock-o"></i> 
                        <?php echo date('d/m/Y', strtotime($document_detail['updated'])); ?>
                    </time>
                </span>
                <span itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
                    <i class="fa fa-user"></i> <?php echo htmlentities(stripslashes($document_detail['name'])); ?>
                </span>
                <span>
                    <?php if (!empty($_SESSION['authentication']['permission']) && is_array($_SESSION['authentication']['permission']) && in_array('backend_post/document/edit', $_SESSION['authentication']['permission'])): ?>
                        <a href="<?php echo 'backend_post/document/edit/' . $document_detail['doc_id']; ?>" title="Sửa">
                            [ <i class="fa fa-pencil" aria-hidden="true"></i> ]
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['authentication']['permission']) && is_array($_SESSION['authentication']['permission']) && in_array('backend_post/document/del', $_SESSION['authentication']['permission'])): ?>
                        <a href="<?php echo 'backend_post/document/del/' . $document_detail['doc_id']; ?>" title="Xóa">
                            [ <i class="fa fa-trash-o" aria-hidden="true"></i> ]
                        </a>
                    <?php endif; ?>
                </span>
            </div>
            <hr>
            <div class="entry-content">
                <p><?php echo!empty($document_detail['doc_description']) ? htmlentities(stripslashes($document_detail['doc_description'])) : ''; ?></p>
                <h4 class="heading">Thông tin</h4>
                <ul>
                    <?php
                    if (!empty($document_detail['doc_name'])) {
                        echo '<li><strong>Tên đề tài: </strong>' . htmlentities(stripslashes($document_detail['doc_name'])) . '</li>';
                    }
                    if (!empty($document_detail['doc_author'])) {
                        echo '<li><strong>Sinh viên thực hiện: </strong>' . htmlentities(stripslashes($document_detail['doc_author'])) . '</li>';
                    }
                    if (!empty($document_detail['instructor'])) {
                        echo '<li><strong>Giảng viên hướng dẫn: </strong>' . htmlentities(stripslashes($document_detail['instructor'])) . '</li>';
                    }
                    if (!empty($document_detail['doc_yearPublish'])) {
                        echo '<li><strong>Năm bảo vệ: </strong>' . $document_detail['doc_yearPublish'] . '</li>';
                    }
                    ?>

                </ul>
                <?php if (!empty($document_detail['doc_file'])): ?>
                    <iframe src="http://docs.google.com/gview?url=<?php echo base_url($document_detail['doc_file']); ?>&embedded=true" style="width:100%;height: 450px;" frameborder="0"></iframe>
                <?php endif; ?>
            </div>
        </article>
    </section>
</div>