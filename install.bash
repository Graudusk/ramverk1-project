#!/usr/bin/env bash
#
file="sql/setup.sql"
mysql -uroot -p < $file

file="sql/ddl/ddl.sql"
mysql -uuser -puser travel --table < $file

file="sql/ddl/insert.sql"
mysql -uuser -puser travel --table < $file
