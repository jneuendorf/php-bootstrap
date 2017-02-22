<?php

require_once 'include_all.php';


// size for convenience only. could also be done by setting `classes = ['btn-xs']`
class Alert extends Component {
    // can't be inherited anyways
    private static $currently_rendered = null;

    public function __construct() {
        $this->set_instance_vars(
            array(
                'args' => array('kind', 'content', 'dismissible', 'id'),
                'defaults' => array(
                    'dismissible' => false,
                    'id' => 'uid_'.uniqid(),
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


    // INSTANCE METHODS

    public function render_begin() {
        return '<div class="alert alert-'.$this->kind.' '.$this->render_classes().'" role="alert" id="'.$this->id.'" '.$this->render_attrs().'>'
            .(
                $this->dismissible
                ?
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                :
                    ''
            );
    }

    // html from modal-content
    public function render_end() {
        return '</div>'
        .(
            $this->dismissible ?
            '<script type="text/javascript">$("#'.$this->id.'").alert();</script>' :
            ''
        );
    }

    public function render() {
        return $this->render_begin()
            .$this->content
            .$this->render_end();
    }
}
