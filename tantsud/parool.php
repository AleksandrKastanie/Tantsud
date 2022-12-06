<?php
$parool = '1234';
$sool = 'taiestisuvalinetekst';
$kryp = crypt($parool, $sool);
echo $kryp;
/*Create table kasutajad(
    id int PRIMARY key AUTO_INCREMENT,
    kasutaja varchar(20),
    parool varchar(50)
)*/