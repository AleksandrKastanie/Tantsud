<?php
$yhendus=new mysqli("localhost", "tarp21", "tarp21", "tarp21");
$yhendus->set_charset('utf8');
/*
 * create table tantsud(
    id int primary key auto_increment,
    tantsupaar varchar(25) not null,
    punktid int default 0,
    kommentaarid varchar(250) default ' ',
    avalik int default 1,
    avaliku_paev datetime
);
 */