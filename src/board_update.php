<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", DOC_ROOT."common/db_common.php" );
    include_once( URL_DB );

    // Request Method를 획득
    $http_method = $_SERVER["REQUEST_METHOD"];
    
    if( $http_method === "GET") // GET일때
    {
        $board_no = 1;
        if( array_key_exists( "board_no", $_GET ) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }
    else // POST일때
    {
        $arr_post = $_POST;
        $arr_info = 
            array(
                "board_no"      =>$arr_post["board_no"]
                ,"board_title"  =>$arr_post["board_title"]
                ,"board_contents"  =>$arr_post["board_contents"]
            );
        
        // update
        $result_cnt = update_board_info_no( $arr_info );

        // select
        $result_info = select_board_info_no( $arr_post["board_no"] );
    }

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link rel="stylesheet" href="./CSS/common.css">
    
</head>
<body>
    <div class="title"><a href="board_list.php"><img src="./img/title1.png" alt="타이틀"></a></div>
    <div class="con">
        <h1>수정</h1>
        <form method="post" action="board_update.php">
            <label for="bno">게시글 번호 : </label>
            <input type="text" name="board_no" id="bno" class="inp"value="<?php echo $result_info["board_no"] ?>" readonly>
            <br>
            <label for="title">게시글 제목 : </label>
            <input type="text" name="board_title" id="title" class="inp" value="<?php echo $result_info["board_title"] ?>">
            <br>
            <label for="contents">게시글 내용 : </label>
            <input type="text" name="board_contents" id="contents" class="inp" value="<?php echo $result_info["board_contents"] ?>">
            <br>
            <button type="submit" class="btn">수정</button>
            <button type="button" onclick="location.href='board_list.php'" class="btn">글목록</button>
        </form>
    </div>
    <footer>
    <p>Copyright © 2023 MY BOARD.co.Ltd. All rights reserved.</p>
    </footer>
</body>
</html>