#!/usr/bin/env bash
#
file="sql/ddl/setupRemote.sql"
mysql -uuser -ppass < $file

file="sql/ddl/ddl.sql"
mysql -uuser -ppass erjh17 --table < $file

file="sql/ddl/insert.sql"
mysql -uuser -ppass erjh17 --table < $file
