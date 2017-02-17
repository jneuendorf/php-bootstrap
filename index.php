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
    <script type="text/javascript" src="js/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <style media="screen">
        body {
            background-color: rgb(236, 236, 236);
        }
        body.modal-open {
            overflow: auto;
        }
        section {
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 0 1px 0 white;
            padding: 10px;
            margin-bottom: 30px;
        }
        .example .modal {
            position: relative;
            top: auto;
            right: auto;
            bottom: auto;
            left: auto;
            z-index: 1;
            display: block;
        }
    </style>
</head>
<body>

<div class="container">

<section><?php
// BUTTON
echo button(['label' => 'button1']);
echo button('button2');
echo button(['label' => 'danger', 'kind' => 'danger']);
echo button('small info btn', 'info', array('cumstom-class', 'cumstom-class2'), 'button', 'xs');
echo button(['label' => 'big boy', 'size' => 'lg']);
echo button(['label' => 'big boy2', 'classes' => ['btn-lg']]);
echo button(['label' => 'submit', 'type' => 'submit']);
echo button(['label' => 'custom', 'attrs' => ['style' => 'color: purple;']]);
?></section>

<section><?php
// BREADCRUMBS
echo breadcrumbs(['Home' => '#', 'Library' => '#', 'Data' => '#']);
echo breadcrumbs(['items' => ['Home' => '#', 'Page']]);
echo breadcrumbs(['Home' => '#', 'No link' => null]);
?></section>

<section class="example"><?php
// BREADCRUMBS
// show modal by avoiding the 'fade' class to be set (by default)
echo modal(['classes' => []]);
echo modal(['header' => null, 'footer' => null, 'body' => 'modal-body only', 'classes' => []]);
echo modal(['title' => 'My Modal', 'footer' => null, 'body' => 'custom title and no footer', 'classes' => []]);
echo modal([
    'header' => null,
    'footer' => button('cool', 'warning'),
    'body' => 'no header and custom button in footer',
    'classes' => []]
);
// show modal by initializing it (without backdrop)
echo modal(['body' => 'initialized with JavaScript (thus it can be closed)', 'initialize' => true, 'attrs' => array('data-backdrop' => 'false')]);

echo modal_begin(['classes' => []]); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="modal-title">Custom HTML</h3>
</div>
<div class="modal-body">
    <h4>This modal's markup is almost written entirely outside of PHP.</h4>
    <form>
        <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
        </div>
        <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Send message</button>
</div>

<?php
echo modal_end();
?></section>

</body>
</html>
