# Server Install
```
$ sudo apt update
$ sudo apt install apache2
$ sudo apt install mysql-server
$ sudo apt install php libapache2-mod-php php-mysql
```

# Download Source
```
$ cd /var/www/html
$ sudo git clone https://github.com/duplanty/quiz.git
$ cd quiz
```

# MySQL Setting
Create Mysql Database `quiz`
```
$ mysql -u USER -p
```
```
> create database quiz;
> exit;
```
```
$ mysql -u USER -p quiz < install.sql
```

# Update Database Config
```
$ sudo vi application/config/database.php
```
Edit mysql user and password
```
	...
	'username' => 'USER',
	'password' => 'PASS',
	...
```

# Apache Setting
```
$ sudo vi /etc/apache2/sites-enabled/000-default.conf
```
Update this setting
```
    DocumentRoot /var/www/html
```
to
```
    DocumentRoot /var/www/html/quiz
    <Directory /var/www/>
        Options All
        AllowOverride All
        Require all granted
        Order deny,allow
        Allow from all
    </Directory>
```

# Final
Enable Rewrite Module
```
$ sudo a2enmod rewrite
```
Restart Apache
```
$ sudo systemctl restart apache2
```
Connect http://YOURDOMAIN/
