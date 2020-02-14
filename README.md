Task is to create simple RSS reader web application with following views:

1. User registration - form with e-mail and password fields + e-mail verification using ajax.

Existence of already registered e-mail should be checked “on the fly” via ajax call
 when writing e-mail address and before submitting form.


2. Login form with e-mail address and password


3. RSS feed view (Feed source: https://www.theregister.co.uk/software/headlines.atom)


*) After successful login in top section display 10 most frequent words with their respective counts
in the whole feed excluding top 50 English common words 
(taken from here https://en.wikipedia.org/wiki/Most_common_words_in_English)
*)Underneath create list of feed items.


There are no restrictions on frameworks (PHP and/or JS) used.
When doing this task please apply the best practices in software development. Add commits with your
code separately from framework code.
Please send the code (archive or link to github) and instructions how to set it up once completed.
---------------------------------------------
To set it up:
1) you clone this repository
2) install composer
3) create table (structure described below)
4) edit database data in /config/database.php

Table structure for table `users`

create table users
(
   id int auto_increment,
   name varchar(100) not null,
   email varchar(100) not null,
   password varchar(100) not null,
   created_at datetime not null,
   token varchar(100) not null,
   tokenExpire_at datetime not null,
   constraint users_pk
      primary key (id)
);

create unique index users_email_uindex
	on users (email);
	
------------------------------------------------
Session time is set to 15secs(after 15seconds of idle it proceeds with logout)

you can set it up as well as App name at /config/app.php