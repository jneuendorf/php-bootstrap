<?php

require_once 'include_all.php';


// size for convenience only. could also be done by setting `classes = ['btn-xs']`
class Alert extends Component {
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

    public function begin() {
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
    public function end() {
        return '</div>'
        .(
            $this->dismissible ?
            '<script type="text/javascript">$("#'.$this->id.'").alert();</script>' :
            ''
        );
    }

    public function render() {
        return $this->begin()
            .$this->content
            .$this->end();
    }
}


function alert() {
    return render_shortcut('Alert', func_get_args());
}

$_currently_rendered_alert = null;
// convenience methods to be able to write alert content in HTML (instead of passing a string in PHP)
function alert_begin() {
    global $_currently_rendered_alert;
    if ($_currently_rendered_alert !== null) {
        throw new Exception('You must call alert_end() before calling '.__FUNCTION__.'() again.', 1);
    }
    $instance = instantiate_shortcut('Alert', func_get_args());
    $_currently_rendered_alert = $instance;
    return $instance->begin();
}

function alert_end() {
    global $_currently_rendered_alert;
    if ($_currently_rendered_alert === null) {
        throw new Exception('You must call alert_begin() before calling '.__FUNCTION__.'().', 1);
    }
    $html = $_currently_rendered_alert->end();
    $_currently_rendered_alert = null;
    return $html;
}
