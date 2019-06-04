<?php

require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$db = new \Core\Database\Connection(DB_CREDENTIALS);
$pdo = $db->getPDO();

$sql = strtr("SELECT * FROM @schema.@table", [
    '@schema' => SQLBuilder::schema(DB_SCHEMA),
    '@table' => SQLBuilder::table(DB_TABLE),
]);

$query = $pdo->query($sql);

$pixels = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<html>

    <?php require '../app/objects/header.php'; ?>

    <body class="index">

        <?php require '../app/objects/navigation.php'; ?>

        <section class="content container-fluid">
            <h1>POOPWALL</h1>
            <div class="poopwall">
                <?php foreach ($pixels as $pixel): ?>
                    <span class="pixel"
                          style="left:<?php print $pixel['x']; ?>px;
                                  top:<?php print $pixel['y']; ?>px;
                                  background-color: <?php print $pixel['color']; ?>;">

                    </span>
                <?php endforeach; ?>
            </div>
        </section>

        <?php require '../app/objects/scripts.php'; ?>

    </body>
</html>

