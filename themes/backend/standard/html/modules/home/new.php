<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="">
    <form action="<?php echo Router::buildLink('modules', array("layout" => "addModule")) ?>" method="post" name="adminForm">
        <a href="<?php echo Router::buildLink('modules', array("layout" => "cancel")) ?>" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove" title="Close"></span> Close
        </a>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span><b>Select a Module Type </b></span>
            </div>
            <div class="panel-body"> 
                <table class="table table-bordered table-hover table-striped ">
                    <tr>
                        <th width="2%"># </th>
                        <th>Name</th>    
                        <th width="25%" align="center">Author</th>
                        <th width="10%">Version</th>
                        <th width="15%">Created Date</th>
                    </tr>
                    <?php
                    if (count($items)) {
                        foreach ($items as $k => $item) {
                            $link_edit = Router::buildLink('modules', array("layout" => 'addModule', 'cid' => $item['id']));
                            echo '<tr onClick="">';
                                echo '<td>'; echo $k + 1; echo '</td>';
                                echo '<td> <b> <a href="'.$link_edit.'">'; echo $item['title']; echo '</a></b></td>';
                                echo '<td>'; echo $item['author']; echo '</td>';
                                echo '<td>'; echo $item['version']; echo '</td>';
                                echo '<td>'; echo $item['creationDate']; echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </table>
            </div>
        </div>

    </form>
</div> 