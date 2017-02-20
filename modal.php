<?php

require_once 'include_all.php';
require_once 'button.php';

/**
 *
 */
class Modal extends Component {
    public function __construct() {
        $this->set_instance_vars(
            array(
                'args' => array('title', 'body', 'footer', 'header', 'id', 'classes', 'attrs', 'initialize'),
                'defaults' => array(
                    'id' => 'uid_'.uniqid(),
                    'classes' => array('fade'),
                    'initialize' => false,
                )
            ),
            func_get_args()
        );
    }

    // html to modal-content
    public function begin() {
        return '<div class="modal '.$this->render_classes().'" id="'.$this->id.'" tabindex="-1" role="dialog" '.$this->render_attrs().' '.($this->show ? 'data-show="true"' : '').'>'
            .'<div class="modal-dialog" role="document">'
                .'<div class="modal-content">';
    }

    // html from modal-content
    public function end() {
        return '</div>'
            .'</div>'
        .'</div>'
        .(
            $this->initialize ?
            '<script type="text/javascript">$("#'.$this->id.'").modal();</script>' :
            ''
        );
    }

    public function get_header() {
        return $this->header === null ? '' :
            '<div class="modal-header">'
                .(
                    $this->header ?
                    $this->header :
                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                    .'<h4 class="modal-title">'
                        .$this->title
                    .'</h4>'
                )
            .'</div>';
    }

    public function get_body() {
        return '<div class="modal-body">'
            .$this->body
        .'</div>';
    }

    public function get_footer() {
        return $this->footer === null ? '' :
            '<div class="modal-footer">'
                .(
                    $this->footer ?
                    $this->footer :
                    button(array('label' => 'Close', 'attrs' => array('data-dismiss' => 'modal')))
                    .button(array('label' => 'Save changes', 'kind' => 'primary'))
                )
            .'</div>';
    }

    public function render() {
        return $this->begin()
            .$this->get_header()
            .$this->get_body()
            .$this->get_footer()
            .$this->end();
    }
}

/**
 * @param ...string $items
 */
function modal() {
    return render_shortcut('Modal', func_get_args());
}


$_currently_rendered_modal = null;
// convenience methods to be able to write modal body in HTML (instead of passing a string in PHP)
function modal_begin() {
    global $_currently_rendered_modal;
    if ($_currently_rendered_modal !== null) {
        throw new Exception('You must call modal_end() before calling '.__FUNCTION__.'() again.', 1);
    }
    $instance = instantiate_shortcut('Modal', func_get_args());
    $_currently_rendered_modal = $instance;
    return $instance->begin();
}

function modal_end() {
    global $_currently_rendered_modal;
    if ($_currently_rendered_modal === null) {
        throw new Exception('You must call modal_begin() before calling '.__FUNCTION__.'().', 1);
    }
    $html = $_currently_rendered_modal->end();
    $_currently_rendered_modal = null;
    return $html;
}

function modal_header() {
    global $_currently_rendered_modal;
    if ($_currently_rendered_modal === null) {
        throw new Exception('You must call modal_begin() before calling '.__FUNCTION__.'().', 1);
    }
    return $_currently_rendered_modal->get_header();
}
function modal_body() {
    global $_currently_rendered_modal;
    if ($_currently_rendered_modal === null) {
        throw new Exception('You must call modal_begin() before calling '.__FUNCTION__.'().', 1);
    }
    return $_currently_rendered_modal->get_body();
}
function modal_footer() {
    global $_currently_rendered_modal;
    if ($_currently_rendered_modal === null) {
        throw new Exception('You must call modal_begin() before calling '.__FUNCTION__.'().', 1);
    }
    return $_currently_rendered_modal->get_footer();
}
