<div class="container">
    <nav class="navbar navbar-default " role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <?php if (!empty($menu['multiMenu'])): ?>
                    <?php foreach ($menu['multiMenu'] as $menu_name => $menuItem): ?>
                        <?php if (!empty($menuItem)): ?>
                            <li>
                                <a href="#"><?php echo htmlentities(stripslashes(substr($menu_name, 0, -1))) ?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($menuItem as $page): ?>
                                        <li><a href="<?php echo 'page/' . $page['page_slug'] . '-' . $page['id']; ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $page['page_name'] ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($menu['singleMenu'])): ?>
                    <?php foreach ($menu['singleMenu'] as $menuItem): ?>
                        <li><a href="<?php echo 'page/' . $menuItem['page_slug'] . '-' . $menuItem['id']; ?>"><?php echo $menuItem['page_name'] ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>



                <li><a href="do-an-tot-nghiep">Kho học liệu</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" data-toggle="modal" data-target="#searchModal">
                        <i class="fa fa-fw fa-search"></i> Tìm kiếm
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->

    </nav>
</div>
<!-- /.container -->