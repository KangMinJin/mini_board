<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php");
    define( "URL_FOOTER", SRC_ROOT."board_footer.php");

    include_once( URL_DB );

    // Request Parameter 획득(GET)
    $arr_get = $_GET;

    // DB에서 게시글 정보 획득
    $result_info = select_board_info_no( $arr_get["board_no"] );
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY BOARD</title>
    <link rel="stylesheet" href="./CSS/common.css">
</head>
<body>
    <?php include_once( URL_HEADER )?>
    <div class="con">
        <table class="detail_t">
            <thead class="table_head">
                <th class="wd_h">    

                    <p><?php echo $result_info["board_no"].". ".$result_info["board_title"]?></p>
                    <p class="board_date"><?php echo $result_info["board_write_date"]?></p>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td class="detail_contents">
                        <p><?php echo $result_info["board_contents"]?></p>
                    </td>
                </tr>
            </tbody>
        </table>
            <button type="button" onclick="location.href='board_update.php?board_no=<?php echo $result_info['board_no']?>'" class="btn">수정</button>
            <button type="button" onclick="location.href='board_delete.php?board_no=<?php echo $result_info['board_no']?>'" class="btn">삭제</button>
            <button type="button" onclick="location.href='board_list.php'" class="btn">글목록</button>
    </div>
    <?php include_once( URL_FOOTER )?>
</body>
</html>