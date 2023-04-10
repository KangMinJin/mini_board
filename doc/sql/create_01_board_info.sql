-- CREATE DATABASE board; -- 데이터베이스 만드는 쿼리문

USE board; -- 데이터베이스 사용할때 쓴다

CREATE TABLE board_info (
	board_no INT PRIMARY KEY AUTO_INCREMENT
	,board_title VARCHAR(100) NOT NULL
	,board_contents VARCHAR(1000) NOT NULL
	,board_write_date DATETIME NOT NULL
	,board_del_flg CHAR(1) DEFAULT('0') NOT NULL
	,board_del_date DATETIME
	)
	
DESC board_info; -- 테이블 만들때 넣은 제약조건 상세히 나온다. 원래는 GUI로 확인하는게 아니라 이렇게 쳐서 확인해야한다