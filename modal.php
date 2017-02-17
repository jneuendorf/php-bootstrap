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

    public function render() {
        return $this->begin()
            .(
                $this->header === null ?
                '' :
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
                .'</div>'
            )
            .'<div class="modal-body">'
                .$this->body
            .'</div>'
            .(
                $this->footer === null ?
                '' :
                '<div class="modal-footer">'
                    .(
                        $this->footer ?
                        $this->footer :
                        button(array('label' => 'Close', 'attrs' => array('data-dismiss' => 'modal')))
                        // .'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                        .button(array('label' => 'Save changes', 'kind' => 'primary'))
                        // .'<button type="button" class="btn btn-primary">Save changes</button>'
                    )
                .'</div>'
            )
            .$this->end();
    }
}

/**
 * @param ...string $items
 */
function modal() {
    return render_shortcut('Modal', func_get_args());
}

$_currently_rendering_modal = null;
// convenience methods to be able to write modal body in HTML (instead of passing a string in PHP)
function modal_begin() {
    global $_currently_rendering_modal;
    if ($_currently_rendering_modal !== null) {
        throw new Exception('You must call modal_end() before calling modal_begin() again.', 1);
    }
    $instance = instantiate_shortcut('Modal', func_get_args());
    $_currently_rendering_modal = $instance;
    return $instance->begin();
}
function modal_end() {
    global $_currently_rendering_modal;
    $html = $_currently_rendering_modal->end();
    $_currently_rendering_modal = null;
    return $html;
}
