mysql -h 127.0.0.1 -P 3306 -u root -p tiger
create database SIBW;
CREATE USER 'jesuslr'@'%' IDENTIFIED BY '150599jlr';
GRANT create, delete, drop, index, insert, select, update, alter, references ON SIBW.* TO 'jesuslr'@'%';
exit
mysql -h 127.0.0.1 -P 3306 -u jesuslr -p 150599jlr
use SIBW
