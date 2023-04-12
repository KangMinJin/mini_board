<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", DOC_ROOT."common/db_common.php" );
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
    <title>Detail</title>
    <link rel="stylesheet" href="./CSS/common.css">
</head>
<body>
    <div class="title"><a href="board_list.php"><img src="./img/title1.png" alt="타이틀"></a></div>
    <!-- <div class="con">
        <p>게시글 번호 : <?php echo $result_info["board_no"]?></p>
        <p>게시글 제목 : <?php echo $result_info["board_title"]?></p>
        <p>작성일 : <?php echo $result_info["board_write_date"]?></p>
        <p>게시글 내용 : <?php echo $result_info["board_contents"]?></p>
        <button type="button" class="btn">
            <a href="board_update.php?board_no=<?php echo $result_info["board_no"]?>">수정</a>
        </button>
        <button type="button" class="btn">
            <a href="board_delete.php?board_no=<?php echo $result_info["board_no"]?>">삭제</a></button>
    </div> -->
    <div class="con">
        <table class="detail_t">
            <thead class="table_head">
                <th class="detail_h">    

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
    <footer>
    <p>Copyright © 2023 MY BOARD.co.Ltd. All rights reserved.</p>
    </footer>
</body>
</html>