<?php

require_once 'include_all.php';


// size for convenience only. could also be done by setting `classes = ['btn-xs']`
class Button extends Component {
    public function __construct() {
        $this->set_instance_vars(
            array(
                // e.g.                  default            submit   sm-lg
                'args' => array('label', 'kind', 'classes', 'type', 'size', 'attrs'),
                'defaults' => array(
                    'kind' => 'default',
                    'type' => 'button',
                )
            ),
            func_get_args()
        );
    }

    public function render() {
        return '<button '
            .'type="'.$this->type.'" '
            .'class="btn btn-'.$this->kind.' '.($this->size ? 'btn-'.$this->size : '').' '.$this->render_classes().'" '
            .$this->render_attrs()
        .'>'
            .$this->label
        .'</button>';
    }
}

/**
 * @param ...string $items
 */
function button() {
    return render_shortcut('Button', func_get_args());
}
