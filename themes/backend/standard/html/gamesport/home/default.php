
<div class="col-sm-12">
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading">

            </div>
            <div class="panel-body">        

                <div class="col-sm-4 col-xs-6 icon">
                    <a href="<?php echo Router::buildLink('gamesport', array("view" => 'tournaments')) ?>">
                        <img alt="Tournaments" src="/images/icons/tournaments.png">
                        <span>Tournaments</span>
                    </a>
                </div>

                <div class="col-sm-4 col-xs-6 icon">
                    <a href="<?php echo Router::buildLink('gamesport', array("view" => 'teams')) ?>">
                        <img alt="Teams" src="/images/icons/groups.png">
                        <span>Teams</span>
                    </a>
                </div>


                <div class="col-sm-4 col-xs-6 icon">
                    <a href="<?php echo Router::buildLink('gamesport', array("view" => 'players')) ?>">
                        <img alt="Players" src="/images/icons/users.png">
                        <span>Players</span>
                    </a>
                </div> 

                <div class="col-sm-4 col-xs-6 icon">
                    <a href="<?php echo Router::buildLink('gamesport', array("view" => 'settings')) ?>">
                        <img alt="Resource" src="/images/icons/setting.png">					
                        <span>Settings</span>
                    </a>
                </div> 

                <div class="col-sm-4 col-xs-6 icon">
                    <a href="<?php echo Router::buildLink('gamesport', array("view" => 'about')) ?>">
                        <img alt="Role" src="/images/icons/about.png">					
                        <span>About</span>
                    </a>
                </div>

            </div>
            <div class="panel-footer">                
               
            </div>
        </div> 
    </div> 
    <div class="col-sm-6">         
        <div class="panel">
            <div class="panel-heading">
                giai dau dang dien ra/vua moi ket thuc/lich thi dau
            </div>
            <div class="panel-body">   

            </div>
             
        </div>
    </div> 
</div> 

<style contenteditable="true" style="display: none;">
    .panel div.icon {
        float: left;
        margin-bottom: 5px;        
        text-align: center;
    }
    .panel div.icon a {
        border: 1px solid #f0f0f0;
        color: #555;
        display: block;
        float: left;
        font-weight: bold;
        text-decoration: none;
        vertical-align: middle;
    }
    .panel div.icon a:hover {
        background: #f9f9f9 none repeat scroll 0 0;
        border-color: #eee #ccc #ccc #eee;
        border-style: solid;
        border-width: 1px;
        color: #0b55c4;
    }
    .panel img {
        margin: 0 auto;
        padding: 10px 0;
        width: 80%;        
    }
    .panel span {
        display: block;
        text-align: center;
    }
</style>