<?php
require_once 'button.php';
require_once 'breadcrumbs.php';
require_once 'modal.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>php-bootstrap</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style media="screen">
        body {
            background-color: rgb(236, 236, 236);
        }
        section {
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 0 1px 0 white;
            padding: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">

<section><?php
// BUTTON
button(['label' => 'button1']);
button('button2');
button(['label' => 'danger', 'kind' => 'danger']);
button('small info btn', 'info', array('cumstom-class', 'cumstom-class2'), 'button', 'xs');
button(['label' => 'big boy', 'size' => 'lg']);
button(['label' => 'big boy2', 'classes' => ['btn-lg']]);
button(['label' => 'submit', 'type' => 'submit']);
button(['label' => 'custom', 'attrs' => ['style' => 'color: purple;']]);
?></section>

<section><?php
// BREADCRUMBS
breadcrumbs(['Home' => '#', 'Library' => '#', 'Data' => '#']);
breadcrumbs(['Home' => '#', 'Page']);
breadcrumbs(['Home' => '#', 'No link' => null]);
?></section>

<section><?php
// BREADCRUMBS
// modal();
?></section>

</body>
</html>
