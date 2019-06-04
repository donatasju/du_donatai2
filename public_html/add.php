<?php

require_once '../bootloader.php';

use Core\Database\SQLBuilder;

$form = [
    'fields' => [
        'x_input' => [
            'label' => 'Type x cords',
            'type' => 'text',
            'placeholder' => 'x koordinate',
            'validate' => [
                'validate_not_empty',
                'validate_is_number',
                'validate_higher_than_0',
                'validate_lower_than_500'
            ]
        ],
        'y_input' => [
            'label' => 'Type y cords',
            'type' => 'text',
            'placeholder' => 'Your y koordinate',
            'validate' => [
                'validate_not_empty',
                'validate_is_number',
                'validate_higher_than_0',
                'validate_lower_than_500'
            ]
        ],
        'colour' => [
            'label' => 'Colour',
            'type' => 'select',
            'options' => [
                'red' => 'Raudona',
                'brown' => 'Ruda',
                'green' => 'Zalia',
                'yellow' => 'Geltona'
            ],
            'placeholder' => 'Colour',
            'validate' => [
                'validate_not_empty'
            ]
        ],
    ],
    'buttons' => [
        'submit' => [
            'text' => 'ideti pixel'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function validate_higher_than_0($field_input, &$field, &$safe_input) {
    if ($field_input >= 0) {
        return true;
    }

    $field['error_msg'] = 'Number must be > 0';
}

function validate_lower_than_500($field_input, &$field, &$safe_input) {
    if ($field_input < 500) {
        return true;
    }

    $field['error_msg'] = 'Number must be < 500';
}

function form_success($safe_input, $form) {
    $db = new \Core\Database\Connection(DB_CREDENTIALS);
    $pdo = $db->getPDO();

    $data = [
        'x' => $safe_input['x_input'],
        'y' => $safe_input['y_input'],
        'color' => $safe_input['colour']
    ];

    $data_columns = array_keys($data);

    $sql = strtr("INSERT INTO @schema.@table (@columns) VALUES (@values)", [
        '@schema' => SQLBuilder::schema(DB_SCHEMA),
        '@table' => SQLBuilder::table(DB_TABLE),
        '@columns' => SQLBuilder::columns($data_columns),
        '@values' => SQLBuilder::binds($data_columns)
    ]);

    $query = $pdo->prepare($sql);

    foreach ($data as $column => $value) {
        $query->bindValue(SQLBuilder::bind($column), $value);
    }

    try {
        $query->execute();
    } catch (PDOException $e) {
        throw new Exception('Database Error: ' . $e->getMessage());
    }
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);
    if ($form_success) {
        $success_msg = 'Pikselis idetas';
    }
}

?>
<html>

    <?php require '../app/objects/header.php'; ?>

    <body class="add">

        <?php require '../app/objects/navigation.php'; ?>

        <section class="content container-fluid form">
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
