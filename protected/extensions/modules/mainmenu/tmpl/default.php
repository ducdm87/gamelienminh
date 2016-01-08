 
<ul class="nav navbar-nav">
    <?php
    if (count($items))
        foreach ($items as $item) {
            $helper->showNodeMenu($item, $showChildren);
        }
    ?>
</ul>

