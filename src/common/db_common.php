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

    function select_board_info_no( &$param_no )
    {
        $sql =
            " SELECT "
            ."  board_no "
            ."  ,board_title "
            ."  ,board_contents "
            ."  ,board_write_date " // 0412 작성일 추가
            ." FROM "
            ."  board_info "
            ." WHERE "
            ." board_no = :board_no "
            ;

        $arr_prepare =
            array(
                ":board_no" => $param_no
            );

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

        return $result[0]; // 가져올 레코드도 단 하나고 fetchAll 로 결과 가져올 때 이차원 배열로 가져오므로 딱 레코드 값만 들어있는 $result[0]로 리턴을 한다
    }


    function update_board_info_no( &$param_arr )
    {
        $sql =
            " UPDATE "
            ."  board_info "
            ." SET "
            ."  board_title = :board_title "
            ."  ,board_contents = :board_contents "
            ." WHERE "
            ." board_no = :board_no "
            ;
        $arr_prepare = 
            array(
                ":board_title"      => $param_arr["board_title"]
                ,":board_contents"  => $param_arr["board_contents"]
                ,":board_no"        => $param_arr["board_no"]
            );

        $obj_conn = null;
        try
        {
            db_conn( $obj_conn ); // PDO object set (DB연결)
            $obj_conn->beginTransaction(); // Transaction 시작
            $stmt = $obj_conn->prepare( $sql ); // statement object 셋팅
            $stmt->execute( $arr_prepare ); // DB request
            $result_cnt = $stmt->rowCount(); // rowCount() 는 update로 영향을 받은 레코드의 수를 알려주는 함수
            $obj_conn->commit();
        }
        catch( Exception $e )
        {
            $obj_conn->rollback(); // return이 오면 작동이 끝나므로 return 앞에 rollback을 쓴다
            return $e->getMessage(); // 에러가 나면 catch다음 finally 실행되고 끝 - 맨 밑의 return $result를 하지 않는다
        }
        finally
        {
            $obj_conn = null; // 연결을 하면 항상 끊어줘야한다!
        }

        return $result_cnt;
    }

    function delete_board_info_no( &$param_no )
    {
        $sql =
            " UPDATE "
            ."  board_info "
            ." SET "
            ."  board_del_flg = '1' " // type이 CHAR이므로 '1' 이렇게 홑따옴표로 감싼다!
            ."  ,board_del_date = NOW() "
            ." WHERE "
            ."  board_no = :board_no "
            ;
        
        $arr_prepare =
            array(
                ":board_no" => $param_no
            );
        
        $obj_conn = null;
        try 
        {
            db_conn( $obj_conn );
            $obj_conn->beginTransaction();
            $stmt = $obj_conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result_cnt = $stmt->rowCount();
            $obj_conn->commit();
        }
        catch( Exception $e)
        {
            $obj_conn->rollback();
            return $e->getMessage();
        }
        finally
        {
            $obj_conn = null;
        }

        return $result_cnt;
    }

    function insert_board_info( &$param_arr )
    {
        $sql =
        " INSERT INTO board_info( "
        ."  board_title "
        ."  ,board_contents "
        ."  ,board_write_date "
        ."  ) "
        ." VALUES( "
        ."  :board_title "
        ."  ,:board_contents "
        ."  ,NOW() "
        ."  ) "
        ;

        $arr_prepare =
            array(
                ":board_title"      => $param_arr["board_title"]
                ,":board_contents"  => $param_arr["board_contents"]
            );
        
        $obj_conn = null;
        try
        {
            db_conn( $obj_conn ); // PDO object set (DB연결)
            $obj_conn->beginTransaction(); // Transaction 시작
            $stmt = $obj_conn->prepare( $sql ); // statement object 셋팅
            $stmt->execute( $arr_prepare ); // DB request
            $result_cnt = $stmt->rowCount(); // rowCount() 는 update로 영향을 받은 레코드의 수를 알려주는 함수
            $obj_conn->commit();
        }
        catch( Exception $e )
        {
            $obj_conn->rollback(); // return이 오면 작동이 끝나므로 return 앞에 rollback을 쓴다
            return $e->getMessage(); // 에러가 나면 catch다음 finally 실행되고 끝 - 맨 밑의 return $result를 하지 않는다
        }
        finally
        {
            $obj_conn = null; // 연결을 하면 항상 끊어줘야한다!
        }

        return $result_cnt;
    }
    // TODO
    // $arr = array("board_title" => "test", "board_contents" => "contents");
    // echo insert_board_info( $arr );
    // TODO

    
    // TODO : test Start
    // $arr =
    //     array(
        //         "limit_num"    => 5
        //         ,"offset"       => 0
        //     );
        // $result = select_board_info_paging( $arr );
        
        // print_r ( $result );
        $i = 20;
        print_r(select_board_info_no( $i ));
        // $arr =
        //     array(
        //         "board_no"  => 1
        //         ,"board_title"  => "test1"
        //         ,"board_contents"   => "test__1"
        //     );
        // echo update_board_info_no( $arr );
    // TODO : test End
?>