<?php

require_once 'include_all.php';

// items: list of
class Breadcrumbs extends Component {
    public function __construct() {
        $this->set_instance_vars(
            array(
                'args' => array('items'),
                'defaults' => array(
                    'items' => array()
                )
            ),
            func_get_args()
        );

        // numeric index => no link
        foreach ($this->items as $key => $value) {
            if (is_numeric($key)) {
                // TODO: is it safe to add and delete stuff to arrays from within a loop? (iterator?)
                $this->items[$value] = null;
                unset($this->items[$key]);
            }
        }
    }

    // last item is active. set href = null|'' to disable <a> tag
    public function render() {
        $items = array_slice($this->items, 0, -1);
        $last_item = array_slice($this->items, -1);
        return '<ol class="breadcrumb '.$this->render_classes().'" '.$this->render_attrs().'>'
            .implode('', array_map(
                function($label, $href) {
                    return '<li>'
                        .($href ? '<a href="'.$href.'">' : '')
                            .$label
                        .($href ? '</a>' : '')
                    .'</li>';
                },
                array_keys($items),
                array_values($items)
            ))
            .implode('', array_map(
                function($label, $href) {
                    return '<li class="active">'
                        .($href ? '<a href="'.$href.'">' : '')
                            .$label
                        .($href ? '</a>' : '')
                    .'</li>';
                },
                array_keys($last_item),
                array_values($last_item)
            ))
        .'</ol>';
    }
}
