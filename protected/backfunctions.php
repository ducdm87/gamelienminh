<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function fnShowPagenationBack($total = 100, $limit = 15, $currentPage = 0, $num_page_step = 10) {
    $totalPage = ceil($total / $limit);
    if ($totalPage <= 1)
        return "";
    if($num_page_step <4) $num_page_step = 4;
    ob_start();
    ?>
    <div class="pagination-form">
        <div class="pagination-list">
            <?php            
            $maxpage = $totalPage < 5 ? $totalPage : 5;
            $startPage = $currentPage - 3;
            if ($startPage <= 0)
                $startPage = 1;
            $endPage = $startPage + ($num_page_step - 1);
            if ($endPage >= $total)
                $endPage = $total;

            if ($currentPage > 4) {
                $event_page = 'onclick="javascript: document.adminForm.page.value=1; submitform();return false;"';
                echo '<a  title="1" ' . $event_page . '> << </a>';
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $page = $i;
                if ($page > $totalPage)
                    continue;
                if ($currentPage == $i) {
                    echo '<span title="'.$i.'" class="active">' . $i . '</span>';
                } else {                    
                    $event_page = 'onclick="javascript: document.adminForm.page.value=' . $i . '; submitform();return false;"';
                    echo '<a title="'.$i.'" ' . $event_page . '>' . $i . '</a>';
                }
            }

            if ($currentPage + 9 < $totalPage) {                 
                $event_page = 'onclick="javascript: document.adminForm.page.value=' . $totalPage . '; submitform();return false;"';
                echo '<a title="'.$totalPage.'" ' . $event_page . '> >> </a>';
            }
            ?>
        </div>
    </div>
    <?php
    $str_out = ob_get_contents();
    ob_end_clean();
    return $str_out;
}
