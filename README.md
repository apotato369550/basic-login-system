# basic-login-system
A basic account-signup, login, logout, and delete system made with HTML, CSS, and PHP

# Hi

This is a basic account creation system build with HTML, CSS, and PHP (with some SQL). The site also has a mailer system.

To set it up, run it on a web server. I ran this with the help of xampp.

How to set up a web server: https://www.youtube.com/watch?v=mXdpCRgR-xE&list=PL0eyrZgxdwhwBToawjm9faF1ixePexft-&index=2

You'll also need to create the databases where the accounts & requests will be saved. To do so, go to "localhost/phpmyadmin" on your url bar after installing xampp and create a database called "login system sample". That's where all the tables will be stored.

Creating the tables:

"users" table:
'''
 CREATE TABLE users (
  userId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  username TINYTEXT NOT NULL,
  userEmail TINYTEXT NOT NULL,
  userPassword LONGTEXT NOT NULL
 );
'''

"resetpassword" table:
'''
 CREATE TABLE users (
  id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  email TEXT NOT NULL,
  selector TEXT NOT NULL,
  token LONGTEXT NOT NULL,
  expiry TEXT NOT NULL
 );
'''

"accountdelete" table:
'''
 CREATE TABLE users (
  id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  username TINYTEXT NOT NULL,
  userEmail TINYTEXT NOT NULL,
  userPassword LONGTEXT NOT NULL
  expiry TEXT NOT NULL
 );
'''

Simply run these commands under the "SQL" tab of your database and you should be good to go:)

The system has a built-in mailer, so you'll need to edit the source code to provide your email and password and such specifically in the "reset-request.inc.php" and "delete-request.inc.php" files.

There will be an indicator in the code as to where to put your email/password. The mailer script was from another person's project that you might want to check out: https://github.com/PHPMailer/PHPMailer

After setting all these up, move the downloaded/cloned files into the "htdocs" under your xampp folder, type in "localhost" in your url bar, and you should be golden.

This is one of my starter projects. It's very buggy and messy, but I'm proud of it. Hope you enjoy.

