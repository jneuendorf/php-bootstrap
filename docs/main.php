<?php
require_once __DIR__.'/../button.php';
require_once __DIR__.'/../alert.php';
require_once __DIR__.'/../breadcrumbs.php';
require_once __DIR__.'/../modal.php';

//documentation helpers
function indent($n) {
    return str_repeat(' ', $n);
}

function is_assoc($arr) {
    if (count($arr) === 0) {
        return false;
    }
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function p($value) {
    if (is_array($value)) {
        return print_arr($value, is_assoc($value), $indent + 4);
    }
    if (is_string($value)) {
        return "'$value'";
    }
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    return $value.'';
}

function print_arr($arr, $is_assoc, $indent=0) {
    if (count($arr) === 0) {
        return '[]';
    }
    $printed = "[\n";
    $size = count($arr);
    $i = 0;
    foreach ($arr as $key => $value) {
        $printed .= indent($indent + 4)
            .($is_assoc ? '['.p($key).'] => ' : '')
            .p($value, $indent + 4)
            // komma if not last element
            .($i < $size - 1 ? ",\n" : '');
        $i++;
    }
    $printed .= "\n".indent($indent).']';
    return $printed;
}

function print_args($args, $is_kwargs) {
    if ($is_kwargs) {
        $printed = print_arr($args[0], $is_kwargs);
    }
    else {
        $printed = print_arr($args, $is_kwargs);
    }
    return htmlentities($printed);
}


function _delegator($func_name, $args, $is_kwargs) {
    echo '<pre>echo '.$func_name.'('.print_args($args, $is_kwargs).')</pre>';
    echo call_user_func_array($func_name, $args).'<br><br><br>';
}

function button_doc() {
    _delegator('button', func_get_args(), true);
}
function button_doc_no_kwargs() {
    _delegator('button', func_get_args(), false);
}

function alert_doc() {
    _delegator('alert', func_get_args(), true);
}
function alert_doc_no_kwargs() {
    _delegator('alert', func_get_args(), false);
}

function breadcrumbs_doc() {
    _delegator('breadcrumbs', func_get_args(), true);
}
function breadcrumbs_doc_no_kwargs() {
    _delegator('breadcrumbs', func_get_args(), false);
}

function modal_doc() {
    _delegator('modal', func_get_args(), true);
}
function modal_doc_no_kwargs() {
    _delegator('modal', func_get_args(), false);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>php-bootstrap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
        code {
            border: 1px solid rgba(170, 170, 170, 0.6);
            border-radius: 4px;
            display: inline-block;
            padding: 4px;
            margin-bottom: 45px;
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

<section style="font-size: 18px; text-align: justify;">
    <h3>
        Easily generate bootstrap elements directly from PHP.<br>
        No more writing the same markup all over the place all the time.
    </h3>
    <br>
    The currently supported elements are <strong>buttons</strong>, <strong>alerts</strong>, <strong>breadcrumbs</strong> and <strong>modals</strong>.
    Below there are some demos showing the according PHP code and the output.
    Generally, you can choose between keyword-like arguments and positional arguments.
</section>


<h1>Button</h1>
<section>
<code>button(string label='', string kind='default', array classes=array(), string type='button', string size='', assoc_array attrs=array())</code>
<?php
// BUTTON
button_doc(['label' => 'button1']);
button_doc_no_kwargs('button2');
button_doc(['label' => 'danger', 'kind' => 'danger']);
button_doc_no_kwargs('small info btn', 'info', array('cumstom-class', 'cumstom-class2'), 'button', 'xs');
button_doc(['label' => 'big boy', 'size' => 'lg']);
button_doc(['label' => 'big boy2', 'classes' => ['btn-lg']]);
button_doc(['label' => 'submit', 'type' => 'submit']);
button_doc(['label' => 'custom', 'attrs' => ['style' => 'color: purple;']]);
?></section>


<h1>Alerts</h1>
<section>
<code>alert(string kind, string content, bool dismissible, string id, classes=array(), assoc_array attrs=array())</code>
<?php
// ALERT
alert_doc_no_kwargs('danger', 'this looks dangerous');
alert_doc(['kind' => 'warning', 'content' => 'indismissible me (not)', 'dismissible' => true]);
?>
<pre>
echo alert_begin([&apos;kind&apos; =&gt; &apos;success&apos;, &apos;dismissible&apos; =&gt; true]); ?&gt;
This is a dismissible alert with a bit more complex HTML (which nobody wants to put into a PHP string).
&lt;a href=&quot;#&quot; class=&quot;alert-link&quot;&gt;This is a link with special markup also.&lt;/a&gt;
&lt;?php
echo button('Check this out');
echo alert_end();
</pre><?php
echo alert_begin(['kind' => 'success', 'dismissible' => true]); ?>
This is a dismissible alert with a bit more complex HTML (which nobody wants to put into a PHP string).
<a href="#" class="alert-link">This is a link with special markup also.</a><br>
<?php
echo button('Check this out');
echo alert_end();
?></section>


<h1>Breadcrumbs</h1>
<section>
<code>breadcrumbs(array items=array(), array classes=array(), assoc_array attrs=array())</code>
<?php
// BREADCRUMBS
breadcrumbs_doc(['Home' => '#', 'Library' => '#', 'Data' => '#']);
?>
<pre>
echo breadcrumbs([
    [&apos;items&apos;] =&gt; [
        [&apos;Homepage&apos;] =&gt; &apos;http://www.google.com&apos;,
        &apos;Page&apos;,
        &apos;Subpage&apos;
    ]
])</pre>
<?php
echo breadcrumbs(['items' => ['Homepage' => 'http://www.google.com', 'Page', 'Subpage']]).'<br><br><br>';
breadcrumbs_doc(['Home' => '#', 'No link' => null]);
?></section>


<h1>Modal</h1>
<section class="example">
<code>modal(string title='', string body='', string footer='', string header='', string id='uid_'.uniqid(), array classes=array('fade'), assoc_array attrs=array(), bool initialize=false)</code>
<?php
echo alert_begin('warning'); ?>
<strong>Note:</strong> 'classes' is set to '[]' to prevent that the 'fade' class is set.
<?php
echo alert_end();


// MODAL
// show modal by avoiding the 'fade' class to be set (by default)
modal_doc(['classes' => []]);
modal_doc(['header' => null, 'footer' => null, 'body' => 'modal-body only', 'classes' => []]);
modal_doc(['title' => 'My Modal', 'footer' => null, 'body' => 'custom title and no footer', 'classes' => []]);
?><pre>
echo modal([
    'header' => null,
    'footer' => button('cool', 'warning'),
    'body' => 'no header and custom button in footer',
    'classes' => []
])
</pre><?php
echo modal([
    'header' => null,
    'footer' => button('cool', 'warning'),
    'body' => 'no header and custom button in footer',
    'classes' => []]
);

// show modal by initializing it (without backdrop)
modal_doc(['body' => 'initialized with JavaScript (thus it can be closed)', 'initialize' => true, 'attrs' => array('data-backdrop' => 'false')]);

// parts defined in pure HTML
?><pre>
echo modal_begin([&apos;footer&apos; =&gt; button(&apos;Button&apos;), &apos;classes&apos; =&gt; []]);
echo modal_header(); ?&gt;
&lt;div class=&quot;modal-body&quot;&gt;
    &lt;h5&gt;
        Only the modal body is written in pure HTML.
    &lt;/h5&gt;
&lt;/div&gt;
&lt;?php
echo modal_footer();
echo modal_end();</pre><?php
echo modal_begin(['footer' => button('Button'), 'classes' => []]);
echo modal_header(); ?>
<div class="modal-body">
    <h5>
        Only the modal body is written in pure HTML.
    </h5>
</div>
<?php
echo modal_footer();
echo modal_end();
?></section>

</body>
</html>
