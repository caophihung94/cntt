<div class="sidebar">
    <?php if (!empty($sidebar)): ?>
        <?php foreach ($sidebar as $block): ?>
            <div class="widget">
                <?php if (!empty($block['title'])): ?>
                    <div class="widget-title"><?php echo htmlentities(stripslashes($block['title'])); ?></div>
                <?php endif; ?>
                <?php if (!empty($block['content'])): ?>
                    <div class="tab-content">
                        <?php echo stripslashes($block['content']); ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>