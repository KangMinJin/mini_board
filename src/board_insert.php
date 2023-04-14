<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php");
    define( "URL_FOOTER", SRC_ROOT."board_footer.php");

    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];

    if( $http_method === "POST" )
    {
        $arr_post = $_POST;
        $result_cnt = insert_board_info( $arr_post );
        header( "Location: board_list.php" );
        exit();
    }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 작성</title>
    <link rel="stylesheet" href="./CSS/common.css">
</head>
<body>
    <?php include_once( URL_HEADER )?>
    <div class="con">
        <table>
            <thead class="table_head">
                <th class="wd_h">글 작성</th>
            </thead>
            <tbody>
                <tr>
                <td>
                    <br>
                    <form method="post" action="board_insert.php">
                    <label for="title">제목</label>
                    <input type="text" name="board_title" id="title" class="inp" required>
                    <br>
                    <div class="lb_al">
                        <label for="contents">내용</label>
                        <textarea name="board_contents" id="contents" rows="10" required></textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn">작성</button>
                    <button type="button" onclick="location.href='board_list.php'" class="btn">취소</button>
                    </form>
                </td>
                </tr>
            </tbody>
        </table>
        
    </div>
    <?php include_once( URL_FOOTER )?>
</body>
</html>