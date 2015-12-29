<?php global $_list_tour_state; ?>
    
<div class="form-tournament-teamjoin">
    <form action="<?php echo Router::buildLink("gamesport", array('view' => 'tournament')); ?>" method="post" name="adminForm" >
        
        <div class="col-md-12">
            <div class="pannel panel-info">
                <div class="panel-body">  
                    <div>
                        <ul class="nav nav-tabs">
                            <li class="tab-head active"><a data-toggle="tab" href="#tab-round"><b>Vòng Bảng</b></a></li>
                            <li class="tab-head"><a data-toggle="tab" href="#tab-round-de"><b>Vòng DE</b></a></li>
                            <li class="tab-head"><a data-toggle="tab" href="#tab-round-finish"><b>Vòng Chung Kết</b></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-round" class="tab-pane fade in active">
                                <ul class="nav nav-tabs">
                                    <li class="tab-head active"><a data-toggle="tab" href="#tab-round-1"><b>Bảng A</b></a></li>                                    
                                    <li class="tab-head"><a data-toggle="tab" href="#tab-round-2"><b>Bảng B</b></a></li>                                    
                                    <li class="tab-head"><a data-toggle="tab" href="#tab-round-3"><b>Bảng C</b></a></li>                                    
                                    <li class="tab-head"><a data-toggle="tab" href="#tab-round-4"><b>Bảng D</b></a></li>                                    
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-round-1" class="tab-pane fade in active">
                                         noi dung 1
                                    </div>
                                    <div id="tab-round-2" class="tab-pane fade"> noi dung 2 </div>
                                    <div id="tab-round-3" class="tab-pane fade"> noi dung 3 </div>
                                    <div id="tab-round-4" class="tab-pane fade"> noi dung 4 </div>
                                </div>
                            </div>
                            <div id="tab-round-de" class="tab-pane fade"> noi dung 2 </div>
                            <div id="tab-round-finish" class="tab-pane fade"> noi dung 3 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="tourID" value="<?php echo Request::getVar('tourID',0); ?>">
        <input type="hidden" name="task" value="">
        <input type="hidden" name="filter_order_Dir" value="">
    </form>
</div>
