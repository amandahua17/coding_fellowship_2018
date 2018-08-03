#!/bin/bash

#distinguish which dump this is (current date)
cdate="$(date +'%m-%d-%Y')"
#echo $cdate
#create new directory for content
cd /tmp
mkdir fellowshipbackup$cdate
cd
#get the mysql dump to create the file | ADD ALL DB TO DUMP HERE
#follow mysqldump -- databases dbname > /tmp/fellowshipbackup$cdate/dbname.sql
mysqldump --databases elly > /tmp/fellowshipbackup$cdate/elly.sql
mysqldump --databases hua > /tmp/fellowshipbackup$cdate/hua.sql
mysqldump --databases lindsay > /tmp/fellowshipbackup$cdate/lindsay.sql
mysqldump --databases nai > /tmp/fellowshipbackup$cdate/nai.sql
mysqldump --databases ohkhaila > /tmp/fellowshipbackup$cdate/ohkhaila.sql
mysqldump --databases prp  > /tmp/fellowshipbackup$cdate/prp.sql
mysqldump --databases sami > /tmp/fellowshipbackup$cdate/sami.sql
mysqldump --databases tyler > /tmp/fellowshipbackup$cdate/tyler.sql
echo just finished dump
tar -zcvf /tmp/cmprsbackup$cdate.tar.gz /tmp/fellowshipbackup$cdate/
#gzip /tmp/testdump$cdate.sql
#sync the dump file with the s3 bucket
aws s3 cp /tmp/cmprsbackup$cdate.tar.gz s3://fellowship-backup
#remove local sqldump files
rm /tmp/cmprsbackup$cdate.tar.gz
rm -r /tmp/fellowshipbackup$cdate

s3cmd --expiry-days=31 --expiry-prefix=cmprsbackup expire s3://fellowship-backup
