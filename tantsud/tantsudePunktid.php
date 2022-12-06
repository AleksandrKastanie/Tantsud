<?php
require_once ('connect.php');

//login session
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}


//Uue tantsupaari lisamine
if (!empty($_REQUEST['paarnimi'])) {
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO tantsud (tantsupaar, avaliku_paev)
    VALUES (?,NOW())");
    $kask -> bind_param("s",$_REQUEST['paarnimi']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//Kommentaaride lisamine
if(isset ($_REQUEST['uuskomment'])) {
    if (!empty($_REQUEST['komment'])) {

            global $yhendus;
            $kask = $yhendus->prepare("UPDATE tantsud SET kommentaarid =CONCAT(kommentaarid, ?)
     WHERE id =?");
            $kommentplus = $_REQUEST['komment'] . "\n";
            $kask->bind_param("si", $kommentplus, $_REQUEST['uuskomment']);
            $kask->execute();
            header("Location: $_SERVER[PHP_SELF]");
        }
}

//punktide lisamine
    if (isset($_REQUEST['punkt'])) {
        global $yhendus;
        $kask = $yhendus->prepare('
UPDATE tantsud SET punktid=punktid+1 WHERE id=?');
        $kask->bind_param("s", $_REQUEST['punkt']);
        $kask->execute();
        header("Location: $_SERVER[PHP_SELF]");
    }
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>TARpv21 tantsud</title>
    <link rel="stylesheet" type="text/css" href="Tantsud.css">
</head>
<body>
<header>
<h1>Tantsud TARpv21</h1>
<br>
    <nav>
        <ul>
            <li><a href="tantsudePunktid.php">Kasutaja leht</a></li>
            <li> <a href="admin.php">Admin leht</a></li>

        </ul>

        </nav>
    <br>
    <br>
    <h2>Kasutaja leht</h2>
</header>
<table>
    <tr>
        <th>
            Tantsupaar
        </th>
        <th>
            Punktid
        </th>
        <th>
            Haldus
        </th>
        <th>
            Kommentaarid
        </th>
        <th>
            Kommentaarid Lisamine
        </th>
    </tr>

    <?php
    // tabeli sisu näitamine
    global $yhendus;
    $kask=$yhendus->prepare('
SELECT id, tantsupaar, punktid, kommentaarid FROM tantsud WHERE avalik=1');
    $kask->bind_result($id, $tantsupaar, $punktid, $kommentaarid);
    $kask->execute();
    while($kask->fetch()){
        echo  "<tr>";
        echo "<td>". $tantsupaar."</td>";
        echo "<td>". $punktid."</td>";
        echo "<td><a href='?punkt=$id'>Lisa 1punkt</a></td>";
        $kommentaarid =nl2br(htmlspecialchars($kommentaarid));
        echo "<td>$kommentaarid.</td>";
        echo "<td>
<form action ='?'>
<input type='hidden' value='$id' name='uuskomment'>
<input type='text' name='komment'>
<input type='submit' value='Ok'>
</form>
</td>";
        echo "</tr>";
    }
    ?>
</table>

<div>
    <h2>Uue tantsupaarid lisamine</h2>
    <form action="?">
        <input type="text" placeholder="Tansupaari nimed" name="paarnimi">
        <input type="submit", value="OK">

    </form>
</div>
</body>