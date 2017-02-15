<?php

require_once 'include_all.php';

class Modal implements Renderable {
    public function __construct() {
        $this->items = func_get_args();
        if (count($this->items) === 0) {
            throw new Exception('There must be at least one breadcrumb given as string.', 1);
        }
    }

    public function render() {
        /*
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        */

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

function modal_
