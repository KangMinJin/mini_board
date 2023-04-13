<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php");
    define( "URL_FOOTER", SRC_ROOT."board_footer.php");

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
        // $result_info = select_board_info_no( $arr_post["board_no"] ); // 0412 del

        header( "Location: board_detail.php?board_no=".$arr_post["board_no"] );
        exit(); // 위에서 header 함수를 써서 redirect 했기 때문에 이후의 소스코드는 실행할 필요가 없다. (exit 이후의 코드는 실행이 되지 않는다)
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
    <?php include_once( URL_HEADER )?>
    <div class="con">
        <table class="detail_t">
            <thead class="table_head">
                <th class="detail_h">수정</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                    <form method="post" action="board_update.php">
                        <br>
                        <label for="title" class="f_l">제목</label>
                        <input type="text" name="board_title" id="title" class="inp" value="<?php echo $result_info["board_title"] ?>" required>
                        <br>
                        <div class="lb_al">
                            <label for="contents" class="f_l">내용</label>
                            <textarea name="board_contents" id="contents" cols="30" rows="10" required ><?php echo $result_info["board_contents"] ?></textarea>
                        </div>
                        <input type="hidden" name="board_no" value="<?php echo $result_info["board_no"]?>">
                        <br>
                        <button type="submit" class="btn">수정</button>
                        <button type="submit" onclick="location.href='board_datail.php?board_no='.<?php echo $result_info['board_no']?>" class="btn">
                        취소
                        </button>
                    </form>
                    <button type="button" onclick="location.href='board_list.php'" class="btn">글목록</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <h1>수정</h1> -->
        <!-- <form method="post" action="board_update.php">
            
            <br>
            <label for="title">제목 : </label>
            <input type="text" name="board_title" id="title" class="inp" value="<?php //echo $result_info["board_title"] ?>" required>
            <br>
            <label for="contents">내용 : </label>
            <textarea name="board_contents" id="contents" cols="30" rows="10" required ><?php //echo $result_info["board_contents"] ?></textarea>
            <br>
            <button type="submit" class="btn">수정</button>
            <button type="submit" onclick="location.href='board_datail.php?board_no='.<?php // echo $result_info['board_no']?>" class="btn">
            취소
            </button>
        </form>
        <button type="button" onclick="location.href='board_list.php'" class="btn">글목록</button> -->
    </div>
    <?php include_once( URL_FOOTER )?>
</body>
</html>