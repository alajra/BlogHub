INSERT INTO users (username, password) VALUES ('abdul', SHA2('abc', 512));
INSERT INTO users (username, password) VALUES ('fahad', SHA2('123', 512));
INSERT INTO users (username, password) VALUES ('fatih', SHA2('xyz', 512));

INSERT INTO posts (title, content, owner_id) VALUES ('My First Post', 'blah blah blah', 1);
INSERT INTO posts (title, content, owner_id) VALUES ('Coding', 'blahsdhasdhasjdh jklashdjk las hdljk sasdj ', 2);
INSERT INTO posts (title, content, owner_id) VALUES ('Advantages of Cloud', 'qweuiwq onc xzm,nc cman  sodaldja', 2);
INSERT INTO posts (title, content, owner_id) VALUES ('very very very looopoooooooooooooooooooooooong post', 'qu10 u01 j01j 0d1i j10j2 01i0 ', 3);
INSERT INTO posts (title, content, owner_id) VALUES ('-', '@#@&#*!#@(* &@( 93812983 y@(*Yr# Y(*Y!23', 3);
INSERT INTO posts (title, content, owner_id) VALUES ('lolololololol', '-=12-3=-=`32-=30`=2-30`2=3093` 932n3 =9`923 ', 3);

INSERT INTO follows (follower, following) VALUES (1, 2);
INSERT INTO follows (follower, following) VALUES (1, 3);
INSERT INTO follows (follower, following) VALUES (2, 3);
INSERT INTO follows (follower, following) VALUES (3, 1);
