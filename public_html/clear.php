<?php

require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$form = [
    'fields' => [],
    'validate' => [],
    'buttons' => [
        'submit' => [
            'text' => 'Clear poopwall'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function form_success($safe_input, $form) {
    $db = new \Core\Database\Connection(DB_CREDENTIALS);
    $pdo = $db->getPDO();

    $sql = strtr("DELETE FROM @schema.@table", [
        '@schema' => SQLBuilder::schema(DB_SCHEMA),
        '@table' => SQLBuilder::table(DB_TABLE),
    ]);

    $pdo->exec($sql);
}


if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);
    if ($form_success) {
        $success_msg = 'Pavyko nuvalyti siena';
    }
}

?>
<html>

    <?php require '../app/objects/header.php'; ?>

    <body class="clear">

        <?php require '../app/objects/navigation.php'; ?>

        <section class="content container-fluid">
            <h1>CLEAR POOPWALL</h1>
            <?php if (!isset($success_msg)): ?>

                <!-- Form -->
                <?php require '../core/objects/form.php'; ?>
            <?php elseif (isset($success_msg)): ?>
                <h2><?php print $success_msg; ?></h2>
            <?php endif; ?>
        </section>

        <?php require '../app/objects/scripts.php'; ?>

    </body>
</html>
