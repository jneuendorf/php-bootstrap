<?php

require_once 'include_all.php';
require_once 'button.php';

/**
 * If `header` is set the `title_id` should be used in the header.
 */
class Modal implements Renderable {
    public function __construct() {
        $this->items = func_get_args();
        if (count($this->items) === 0) {
            throw new Exception('There must be at least one breadcrumb given as string.', 1);
        }
    }

    public function render() {
        return '<div class="modal fade '.$this->render_classes().'" id="'.$this->id.'" tabindex="-1" role="dialog" aria-labelledby="'.$this->title_id.'" '.$this->render_attrs().'>'
            .'<div class="modal-dialog" role="document">'
                .'<div class="modal-content">'
                    .'<div class="modal-header">'
                        .(
                            $this->header ?
                            $this->header :
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                            .'<h4 class="modal-title" id="'.$this->title_id.'">'
                                .$this->title
                            .'</h4>'
                        )
                    .'</div>'
                    .'<div class="modal-body">'
                        .$this->body
                    .'</div>'
                    .'<div class="modal-footer">'
                        .(
                            $this->footer ?
                            $this->footer :
                            button(array('label' => 'Close', 'attrs' => array('data-dismiss' => 'modal')))
                            // .'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                            .button(array('label' => 'Save changes', 'kind' => 'primary'))
                            // .'<button type="button" class="btn btn-primary">Save changes</button>'
                        )
                    .'</div>'
                .'</div>'
            .'</div>'
        .'</div>';

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
function modal() {
    return render_shortcut('Modal', func_get_args());
}

// convenience methods to be able to write modal body in HTML (instead of passing a string in PHP)
function modal_begin() {

}
