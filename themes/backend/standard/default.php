<!DOCTYPE html>
<?php global $hideMenu, $mainframe; 
$tmpl = Request::getVar('tmpl',null);
?>
<html lang="en">
    <?php echo $this->renderPartial('/block/header'); ?>
    <body class="<?php echo "tmpl-$tmpl"; ?>">

        <div id="wrapper" <?php if(getSysConfig("sidebar.display", 1)== 0) echo 'style="padding:0; "'; ?>>

            <!-- Sidebar -->
            <?php if($tmpl !== "app"){ ?>
                <?php echo $this->renderPartial('/block/sidebar'); ?>
                <?php YiiMessage::showMessage(); ?>
            <?php }?>
            <div id="page-wrapper">                
                <?php if($tmpl !== "app"){ ?>
                    <?php $this->showToolbar(); ?>
                    <?php $mainframe->showSubMenu(); ?>
                <?php }?>
                <?php echo $content; ?>
            </div><!-- /#page-wrapper -->

        </div><!-- /#wrapper -->
    </body>
</html>

<div id="sbox-overlay" style="z-index: 65555; display: none; position: fixed; top: 0px; left: 0px; visibility: visible; opacity: 0.7; width: 100%; height: 100%;" class=""></div>
<div id="sbox-window" style="display: none; height: 600px; left: 50%;  margin-left: -500px;  margin-top: -300px;     position: fixed;     top: 50%;     width: 1070px;     z-index: 65557;">    
    <a id="sbox-btn-close" href="#"></a>    
    <div id="sbox-content"></div>
    <div id="control-slide">
        <div class="buttun control-back" style="left: -66px; z-index: 9999;">&nbsp;</div>
        <div class="buttun control-next" style="right: -66px; z-index: 9999;">&nbsp;</div>
    </div>
</div>