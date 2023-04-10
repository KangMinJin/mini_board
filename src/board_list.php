<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
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

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
    <style>
        *{
            margin : 0;
            box-sizing: border-box;
        }
        .con1{
            width : 50%;
            margin : auto;
        }
        .find_btn{
            text-align: center;
            margin: auto;
        }
        a{
            display :inline-block;
        }
    </style>
</head>
<body>
    <div class="con1">
        <table class="table table-striped">
            <thead>
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>작성일자</th>
            </thead>
            <tbody>
                <?php
                    foreach( $result_paging as $recode )
                    { // php와 html을 분리해서 작성한다
                ?>
                    <tr>
                        <td><?php echo $recode["board_no"] ?></td>
                        <td><?php echo $recode["board_title"] ?></td>
                        <td><?php echo $recode["board_write_date"] ?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
        <div class="find_btn">
            <?php
            for ( $i = 1 ; $i <= $max_page_num ; $i++ )
            {
                ?>
                <a href="board_list.php?page_num=<?php echo $i?>" class="btn btn-primary"><?php echo $i ?></a>
                <?php
            }
            ?>
        </div>
</body>
</html>