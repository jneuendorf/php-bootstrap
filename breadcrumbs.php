<?php

require_once 'include_all.php';

class Breadcrumbs implements Renderable {
    public function __construct() {
        $this->items = func_get_args();
        if (count($this->items) === 0) {
            throw new Exception('There must be at least one breadcrumb given as string.', 1);
        }
    }

    public function render() {
        return '<ol class="breadcrumb">'
            .implode(
                '',
                array_map(
                    function($item) {
                        return "<li><a href=\"#\">$item</a></li>";
                    },
                    array_slice($this->items, 0, -1)
                )
            )
            .'<li class="active">'.array_slice($this->items, -1)[0].'</li>'
        .'</ol>';
    }
}

/**
 * @param ...string $items
 */
function breadcrumbs() {
    return render_shortcut('Breadcrumbs', func_get_args());
}
