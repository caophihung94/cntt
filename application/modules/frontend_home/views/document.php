<div class="main-list">
    <div class="widget-title">Danh sách đồ án tốt nghiệp</div>
    <?php if (!empty($list_documents) && is_array($list_documents)): ?>
        <?php foreach ($list_documents as $document): ?>
            <article>
                <div class="row">
                    <div class="col-sm-4">
                        <a href="<?php echo 'do-an-tot-nghiep/' . $document['doc_slug'] . '-' . $document['doc_id'] . '.html'; ?>">
                            <img src="<?php echo!empty($document['doc_image']) ? $document['doc_image'] : 'template/frontend/images/default-banner.jpg'; ?>" class="img-thumbnail center-block thumbnail-post-by-category" alt="<?php echo htmlentities(stripslashes($document['doc_name'])); ?>">
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <div class="info">
                            <span>
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <time><?php echo date('d/m/Y', strtotime($document['updated'])); ?></time>
                            </span>
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <?php echo htmlentities(stripslashes($document['name'])); ?>
                            </span>

                        </div>
                        <h4>
                            <a href="<?php echo 'do-an-tot-nghiep/' . $document['doc_slug'] . '-' . $document['doc_id'] . '.html'; ?>"><?php echo htmlentities(stripslashes($document['doc_name'])); ?></a>
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