### Panel Radio
Radio Panel for servers Shoutcast2

### Installing
1. Setup /app/config.php
2. Import the radio.sql
3. Access yoursite.com/crypt/YOUR_PASSWORD and get the password hashed
4. Put this password in the table "admins" where the user admin is created
5. Permisiuni 777 for (temp, uploads, files/linux/sc_serv.bin, files/linux/sc_trans.bin)
6. Edit settings PHP [max_execution_time  120] , [post_max_size 1000M], [upload_max_filesize 1000M]
7. Done it's alright!

### Requires
- PHP 7.0+
- MySQL 5.5+