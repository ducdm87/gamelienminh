 
<form name="adminForm" method="post" action="">   
    <table class="adminlist" cellpadding="1">
        <thead>
            <tr>
                <th width="2%" class="title"> #	</th>                
                <th class="title"> <a>Name</a></th>
                <th class="title" width="10%"> <a>Type</a></th>                
                <th class="title" width="3%"> <a>Status</a></th>
                <th class="title" width="3%"> <a>Allow all</a></th>
                <th class="title" width="7%"> <a>Version</a></th>
                <th class="title" width="15%"> <a>Date </a></th>
                <th class="title" width="20%"> <a>Author</a></th>
                <th class="title"  width="3%"> <a>ID</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
            foreach ($extentions as $i => $item) {                
                ?>
                <tr class="row1" style="<?php if($item['required'] == 1) echo "color: #999;"; ?>">
                    <td><?php echo ($i + 1); ?></td>
                    <td>
                        <input type="radio" <?php if($item['required'] == 1) echo "disabled"; ?> onclick="isChecked(this.checked);" value="<?php echo $item['id'] ?>" name="cid">
                            <?php echo $item['title']; ?>
                    </td>
                    <td><?php echo $item['type']; ?></td>
                    <td><?php echo buildHtml::status($i, $item['status']); ?></td>
                    <td><?php echo buildHtml::changState($i, $item['allowall'],'allowall.'); ?></td>
                    <td><?php echo $item['version']; ?></td>
                    <td><?php echo $item['creationDate']; ?></td>
                    <td><?php echo $item['author']; ?></td>
                    <td><?php echo $item['id'] ?></td>
                </tr>
                <?php $k = 1 - $k;
            }
            ?>
        </tbody>


    </table>
    <input type="hidden" value="0" name="boxchecked">
    <input type="hidden" value="" name="filter_order">
    <input type="hidden" value="" name="filter_order_Dir">
    <input type="hidden" value="" name="task" />
</form>




