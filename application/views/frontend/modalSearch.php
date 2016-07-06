<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="searchModalLabel">Tìm kiếm:</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('search'); ?>" method="get" id="site_search">
                    <div class="input-group">
                        <input class="form-control" name="keyword" type="text" id="search_box" autofocus>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Tìm</button>
                        </span>
                    </div>
                </form>
                <ul style="display: block; margin-top: 15px;" id="search_results"></ul>
            </div>
        </div>
    </div>
</div>