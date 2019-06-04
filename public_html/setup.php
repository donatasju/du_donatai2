<?php

require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$db = new \Core\Database\Connection(DB_CREDENTIALS);
$pdo = $db->getPDO();
//$create = new \Core\Database\Schema($db, DB_SCHEMA);
//$create->create();

$sql = strtr("CREATE TABLE @schema.@table (@x VARCHAR(255) NOT NULL, @y VARCHAR(255) NOT NULL, @color VARCHAR (255) NOT NULL)", [
    '@schema' => SQLBuilder::schema(DB_SCHEMA),
    '@table' => SQLBuilder::table(DB_TABLE),
    '@x' => SQLBuilder::column('x'),
    '@y' => SQLBuilder::column('y'),
    '@color' => SQLBuilder::column('color')
]);

$pdo->exec($sql);

?>
<html>

    <?php require '../app/objects/header.php'; ?>

    <body class="setup">

        <?php require '../app/objects/navigation.php'; ?>
        <?php require '../app/objects/scripts.php'; ?>

    </body>
</html>