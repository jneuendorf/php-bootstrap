<?php

function arr_get($arr, $key, $default = null) {
    if (array_key_exists($key, $arr)) {
        return $arr[$key];
    }
    return $default;
}

/**
 * Returns first trueish argument or last argument.
 */
// function first_of() {
//     foreach (func_get_args() as $value) {
//         if ($value) {
//             return $value;
//         }
//     }
//     return $value;
// }


/**
 * This does not work no empty argument lists.
 * And it also does not make sense in that case.
 *
 * @param string[] $keywords List of keywords that specify keyword-argument parsing.
 */
function keywordify_args($args, $args_order) {
    // already keyword arguments => missing keys will be filled up with `null`
    $args_is_keyworded = count($args) === 1 && is_array($args[0]);
    // var_dump($args);
    // var_dump('$args_is_keyworded = '.($args_is_keyworded ? 't' : 'f'));
    //  check if all keywords exist in $args_order
    if ($args_is_keyworded) {
        foreach ($args[0] as $key => $value) {
            if (!in_array($key, $args_order)) {
                // var_dump('args not interpreted as kwargs because '.$key.' does not appear in args_order.');
                $args_is_keyworded = false;
                break;
            }
        }
    }
    // var_dump('$args_is_keyworded = '.($args_is_keyworded ? 't' : 'f'));
    // we assume the first param is the keyword arguments => unpack
    if ($args_is_keyworded) {
        $args = $args[0];
    }
    // var_dump('$args_is_keyworded = '.($args_is_keyworded ? 't' : 'f'));
    // var_dump($args);

    $keywordified_args = array();
    foreach ($args_order as $idx => $arg_name) {
        if ($args_is_keyworded) {
            $key = $arg_name;
            // $keywordified_args[$arg_name] = arr_get($args, $arg_name);
        }
        else {
            $key = $idx;
            // $keywordified_args[$arg_name] = arr_get($args, $idx);
        }
        if (array_key_exists($key, $args)) {
            $keywordified_args[$arg_name] = $args[$key];
        }
    }
    return $keywordified_args;
}

function instantiate_shortcut($cls, $args) {
    // PHP-VERSION: >= 5.1.3
    $reflection = new ReflectionClass($cls);
    $instance = $reflection->newInstanceArgs($args);
    return $instance;
}

function render_shortcut($cls, $args) {
    $instance = instantiate_shortcut($cls, $args);
    return $instance->render();
}
