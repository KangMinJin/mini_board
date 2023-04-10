<?php
    function db_conn( &$param_conn )
    {
        $host = "localhost";
        $user = "root";
        $pass = "root506";
        $charset = "utf8mb4";
        $db_name = "board";
        $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
        $pdo_option =
            array(
                PDO::ATTR_EMULATE_PREPARES      => false
                ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
                ,PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
            );

        try
        {
            $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
        }
        catch ( Exception $e )
        {
            $param_conn = null;                       // $param_conn을 초기화시키고,
            throw new Exception( $e->getMessage() ); // db_conn을 호출을 한 곳으로 에러를 던저준다 -> select_board_info_paging()의 catch로 바로 던져진다
        }
    }

    function select_board_info_paging( &$param_arr )
    {
        $sql =
            " SELECT "
            ."  board_no "
            ."  ,board_title "
            ."  ,board_write_date "
            ." FROM "
            ."  board_info "
            ." WHERE "
            ."  board_del_flg = '0' "
            ." ORDER BY "
            ."  board_no DESC "
            ." LIMIT :limit_num OFFSET :offset "
            ;
// 쿼리문에서만 " 쿼리 " 이런식으로 앞뒤 모두 다 띄어쓰기한다.
        $arr_prepare =
            array(
                ":limit_num"    => $param_arr["limit_num"]
                ,":offset"      => $param_arr["offset"]
            );
// prepare 문에서는 " :limit_num "처럼 띄어쓰기 하면 안된다! ":limit_num" 처럼 띄어쓰기 안 해야함!
            $obj_conn = null;
        try
        {
            db_conn( $obj_conn );
            $stmt = $obj_conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result = $stmt->fetchAll();
        }
        catch( Exception $e )
        {
            return $e->getMessage(); // 에러가 나면 catch다음 finally 실행되고 끝 - 맨 밑의 return $result를 하지 않는다
        }
        finally
        {
            $obj_conn = null; // 연결을 하면 항상 끊어줘야한다!
        }

        return $result;
    }

    function select_board_info_cnt()
    {
        $sql =
            " SELECT "
            ."  COUNT(*) cnt "
            ." FROM "
            ."  board_info "
            ." WHERE "
            ."  board_del_flg = '0' "
            ;
        $arr_prepare = array();

        $obj_conn = null;
        try
        {
            db_conn( $obj_conn );
            $stmt = $obj_conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result = $stmt->fetchAll();
        }
        catch( Exception $e )
        {
            return $e->getMessage();
        }
        finally
        {
            $obj_conn = null;
        }

        return $result;
    }

    // TODO : test Start
    // $arr =
    //     array(
    //         "limit_num"    => 5
    //         ,"offset"       => 0
    //     );
    // $result = select_board_info_paging( $arr );

    // print_r ( $result );
    // TODO : test End
?>