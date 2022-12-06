<?php
require_once('connect.php');
//login session
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: login.php');
    exit();
}



//punktide nulliks
if (isset($_REQUEST['punkt0'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET punktid=0 WHERE id=?');
    $kask->bind_param("s", $_REQUEST['punkt0']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

//peitmine
if (isset($_REQUEST['peitmine'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET avalik=0 WHERE id=?');
    $kask->bind_param("i", $_REQUEST['peitmine']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

//näitamine
if (isset($_REQUEST['naitamine'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET avalik=1 WHERE id=?');
    $kask->bind_param("i", $_REQUEST['naitamine']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

//kustutamine paari
if (isset($_REQUEST["kustutusid"])) {
    global $yhendus;
    $kask = $yhendus->prepare("DELETE FROM tantsud WHERE id=?");
    $kask->bind_param("s", $_REQUEST['kustutusid']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}


//kommentaari kustutamine
if (isset($_REQUEST['komment0'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET kommentaarid="" WHERE id=?');
    $kask->bind_param("s", $_REQUEST['komment0']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>tantsudTARpv21</title>
    <link rel="stylesheet" type="text/css" href="Tantsud.css">
</head>
<body>
<header>
    <h1>Tantud TARpv21</h1>
    <br>
    <nav>
        <ul>
            <li><a href="tantsudePunktid.php">Kasutaja leht</a></li>
            <li> <a href="admin.php">Admin leht</a></li>

        </ul>

    </nav>
    <br>
    <br>
    <h2>Admin leht</h2>
</header>
<table>
    <tr>
        <th>Kustuta lisamine</th>
        <th>Tantsupaar</th>
        <th>Punktid<br>Punktid nulliks</th>
        <th>Kommentaarid</th>
        <th>Status</th>
        <th>Avalikustamise päev</th>

    </tr>
    <?php
    // tabeli sisu näitamine
    global $yhendus;
    $kask = $yhendus->prepare('
SELECT id, tantsupaar, punktid, kommentaarid, avaliku_paev, avalik FROM tantsud');
    $kask->bind_result($id, $tantsupaar, $punktid, $kommentaarid, $avaliku_paev, $avalik);
    $kask->execute();
    while ($kask->fetch()) {
        echo "<tr>";
        ?>
        <td><a href="?kustutusid=<?=$id ?>"
               onclick="return confirm('Kas ikka soovid kustutada?')">Kustutada</a>
        </td>
        <?php
        $tekst = 'Näita';
        $seisund = 'naitamine';
        $kasutajatekst = 'Kasutaja ei näe';
        if ($avalik == 1) {
            $tekst = 'Peida';
            $seisund = 'peitmine';
            $kasutajatekst = 'Kasutaja näeb';
        }
            echo "<td>" . $tantsupaar . "</td>";
            echo "<td>" . $punktid . "<br><a href='?punkt0=$id'>punktd nulliks</a></td>";
            $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
            echo "<td>" . $kommentaarid . "<br><a href='?komment0=$id'>kustuta kommenti</a></td>";

            echo "<td>$kasutajatekst<br>
            <a href='?$seisund=$id'>$tekst</a><br>
            
            
            </td>";
            echo "<td>" . $avaliku_paev . "</td>";

        echo "</tr>";
    }
    ?>
</table>
<br>
<?php
echo $_SESSION['kasutaja'] ?>
 on sise logitud
<form action="logout.php" method="post">
    <input type="submit" value="Logi välja" name="logout">
</form>
</body>
</html>
