<?php

require_once 'include_all.php';
require_once 'button.php';

/**
 *
 */
class Modal extends Component {
    // can't be inherited anyways
    private static $currently_rendered = null;

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


    // STATIC METHODS

    // convenience methods to be able to write modal body in HTML (instead of passing a string in PHP)
    public static function begin() {
        if (static::$currently_rendered !== null) {
            throw static::get_exception('end', __FUNCTION__);
        }
        $instance = instantiate_shortcut(get_called_class(), func_get_args());
        static::$currently_rendered = $instance;
        return $instance->render_begin();
    }

    public static function end() {
        if (static::$currently_rendered === null) {
            throw static::get_exception('begin', __FUNCTION__);
        }
        $html = static::$currently_rendered->render_end();
        static::$currently_rendered = null;
        return $html;
    }

    public static function header() {
        if (static::$currently_rendered === null) {
            throw static::get_exception('begin', __FUNCTION__);
        }
        return static::$currently_rendered->render_header();
    }

    public static function body() {
        if (static::$currently_rendered === null) {
            throw static::get_exception('begin', __FUNCTION__);
        }
        return static::$currently_rendered->render_body();
    }

    public static function footer() {
        if (static::$currently_rendered === null) {
            throw static::get_exception('begin', __FUNCTION__);
        }
        return static::$currently_rendered->render_footer();
    }


    // INSTANCE METHODS

    // html to modal-content
    public function render_begin() {
        return '<div class="modal '.$this->render_classes().'" id="'.$this->id.'" tabindex="-1" role="dialog" '.$this->render_attrs().' '.($this->show ? 'data-show="true"' : '').'>'
            .'<div class="modal-dialog" role="document">'
                .'<div class="modal-content">';
    }

    // html from modal-content
    public function render_end() {
        return '</div>'
            .'</div>'
        .'</div>'
        .(
            $this->initialize ?
            '<script type="text/javascript">$("#'.$this->id.'").modal();</script>' :
            ''
        );
    }

    public function render_header() {
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

    public function render_body() {
        return '<div class="modal-body">'
            .$this->body
        .'</div>';
    }

    public function render_footer() {
        return $this->footer === null ? '' :
            '<div class="modal-footer">'
                .(
                    $this->footer ?
                    $this->footer :
                    Button::create(array('label' => 'Close', 'attrs' => array('data-dismiss' => 'modal')))
                )
            .'</div>';
    }

    public function render() {
        return $this->render_begin()
            .$this->render_header()
            .$this->render_body()
            .$this->render_footer()
            .$this->render_end();
    }
}
