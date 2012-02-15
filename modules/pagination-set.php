<?php
    $limit_statement = null;
    if(isset($get) && !empty ($get)) $page = $get;
    if(is_numeric($page)) {
        $start = ($page-1) * $limit;
        $limit_statement = $start.", ".$limit;
    }
?>
