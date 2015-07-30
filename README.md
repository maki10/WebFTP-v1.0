# OOP WebFTP
Connect to your server ftp section i recommend vsftpd
If you have hidden stuff like .htaccess ftp can't deleted it because don't see it.
So you must edit your vsftpd.conf and add a line "force_dot_files=YES" and "service vsftpd restart".
Then you can delete hidden file in folder with my scripts :)
