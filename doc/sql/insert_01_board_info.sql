-- 게시글 제목 : 제목 n
-- 게시글 내용 : 내용 n
-- 작성일 : 현재일자


INSERT INTO board_info (
	board_title
	,board_contents
	,board_write_date)
VALUES (
	'제목20'
	,'내용20'
	,NOW()
	);
	
-- TRUNCATE TABLE board_info; -- auto_increment는 delete로 레코드 삭제시엔 초기화가 되지 않으므로 truncate로 날려서 초기화 시켜줘야한다
-- 사실 truncate 쓰는 것 보단 ALTER TABLE 테이블명 AUTO_INCREMENT = 숫자; 로 초기화해줘야한다.
SELECT * FROM board_info;

-- COMMIT;