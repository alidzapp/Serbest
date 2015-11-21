/*
  This first section is optional, however its probably the best method
  of running Serbest on Oracle. If you already have a tablespace and user created
  for Serbest you can leave this section commented out!

  The first set of statements create a src tablespace and a src user,
  make sure you change the password of the src user before you run this script!!
*/

/*
CREATE TABLESPACE "src"
	LOGGING
	DATAFILE 'E:\ORACLE\ORADATA\LOCAL\src.ora'
	SIZE 10M
	AUTOEXTEND ON NEXT 10M
	MAXSIZE 100M;

CREATE USER "src"
	PROFILE "DEFAULT"
	IDENTIFIED BY "src_password"
	DEFAULT TABLESPACE "src"
	QUOTA UNLIMITED ON "src"
	ACCOUNT UNLOCK;

GRANT ANALYZE ANY TO "src";
GRANT CREATE SEQUENCE TO "src";
GRANT CREATE SESSION TO "src";
GRANT CREATE TABLE TO "src";
GRANT CREATE TRIGGER TO "src";
GRANT CREATE VIEW TO "src";
GRANT "CONNECT" TO "src";

COMMIT;
DISCONNECT;

CONNECT src/src_password;
*/
