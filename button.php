<?php

require_once 'include_all.php';

class Button implements Renderable {
    public function __construct() {
        $args = parse_args(
            func_get_args(),
            array('label', 'kind', 'type', 'size')
        );
        $this->label = first_of($args['label'], '');
        $this->kind = first_of($args['kind'], 'default');
        $this->type = first_of($args['type'], 'button'); // submit
        $this->size = first_of($args['size'], ''); // sm, lg
    }

    public function render() {
        return '<button type="'.$this->type.'" class="btn btn-'.$this->kind.($this->size !== '' ? ' btn-'.$this->size : '').'">'.$this->label.'</button>';
    }
}

/**
 * @param ...string $items
 */
function button() {
    return render_shortcut('Button', func_get_args());
}
