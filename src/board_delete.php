<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    include_once( URL_DB );

    $arr_get = $_GET;

    $result_cnt = delete_board_info_no( $arr_get["board_no"] );

    header( "Location: board_list.php" );
    exit();
?>