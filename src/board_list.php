<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", DOC_ROOT."common/db_common.php" );
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];

    if( array_key_exists( "page_num", $_GET ) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }
    // if( $http_method === "GET")
    // {
    //     $arr_get = $_GET;
    //     $page_num = $arr_get["page_num"];
        
    // }
    // else
    // {
    //     $page_num = 1;
    // }

    $limit_num = 5;

    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    // offset 계산
    $offset = ( $page_num * $limit_num ) - $limit_num;

    // max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num ); // fetchAll로 넘어올땐 값이 문자열로 오기 때문에 (int)를 붙여서 형변환을 해 주고
    // 배열로 넘어오기 때문에 (int)$result_cnt[0]["cnt"]라고 작성한다

    $arr_prepare =
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
    $result_paging = select_board_info_paging( $arr_prepare );
    // var_dump( $max_page_num );
?>
<!-- xcopy D:\Students\KMJ\workspace\mini_board\src C:\Apache24\htdocs\mini_board\src /E /H /F /Y -->

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <title>게시판</title>
    <link rel="stylesheet" href="./CSS/common.css">
</head>
<body>
    <div class="title"><a href="board_list.php"><img src="./img/title1.png" alt="타이틀"></a></div>
    <div class="con">
        <div class="con1">
            <table >
                <thead class="table_head">
                    <th class="th_1">게 시 글  번 호</th>
                    <th>게 시 글  제 목</th>
                    <th class="th_3">작 성 일 자</th>
                </thead>
                <tbody>
                    <?php
                        foreach( $result_paging as $recode )
                        { // php와 html을 분리해서 작성한다
                    ?>
                        <tr>
                            <td><?php echo $recode["board_no"] ?></td>
                            <td><a class ="title" href="board_detail.php?board_no=<?php echo $recode["board_no"]?>"><?php echo $recode["board_title"] ?></a></td>
                            <td><?php echo $recode["board_write_date"] ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <!-- <button type="submit"></button> -->
        </div>
        
        
        <div class = "find_search">
            <input type="text" class="search">
            <button type="submit" class="search_btn">검색</button>
            <br>
        </div>
        <div class="find_btn">
                <?php
                $previous_page = $page_num-1;
                if( $page_num > 1 )
                {?>
                    <a href="board_list.php?page_num=<?php echo $previous_page?>" class="btn"><</a>
                <?php
                }
                else
                {?>
                <a href="board_list.php?page_num=<?php echo $page_num?>" class="btn"><</a>
                <?php
                }?>
                <?php
                for ( $i = 1 ; $i <= $max_page_num ; $i++ )
                {
                    ?>
                    <a href="board_list.php?page_num=<?php echo $i?>" class="btn"><?php echo $i ?></a>
                    <?php
                }
                ?>
                <?php
                $next_page = $page_num+1;
                if( $page_num < $max_page_num)
                {?>
                    <a href="board_list.php?page_num=<?php echo $next_page?>" class="btn">></a>
                <?php
                }
                else
                {?>
                <a href="board_list.php?page_num=<?php echo $page_num?>" class="btn">></a>
                <?php
                }?>
            </div>
    </div>
    <footer>
    <p>Copyright © 2023 MY BOARD.co.Ltd. All rights reserved.</p>
    </footer>
</body>
</html>