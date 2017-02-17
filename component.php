<?php

require_once 'renderable.php';
require_once 'helpers.php';


abstract class Component implements Renderable {

    protected $classes;
    protected $attrs;

    /**
     * Converts the $given_args into a dictionary that will be used to set the according instance variables.
     * See constructors of subclasses for examples.
     * 'classes' and 'attrs' are optional. If they're not given they will be added as last positional arguments.
     */
    protected function set_instance_vars($arg_config, $given_args) {
        $default_vars = array('classes' => array(), 'attrs' => array());
        foreach ($default_vars as $var_name => $default_value) {
            if (!in_array($var_name, $arg_config['args'])) {
                array_push($arg_config['args'], $var_name);
                // $arg_config['defaults'][$var_name] = $default_value;
            }
            if (!array_key_exists($var_name, $arg_config['defaults'])) {
                $arg_config['defaults'][$var_name] = $default_value;
            }
        }

        // var_dump($arg_config);

        $keyword_args = keywordify_args(
            $given_args,
            $arg_config['args']
        );
        // var_dump($keyword_args);
        $default_value = '';
        foreach ($arg_config['args'] as $arg_name) {
            $this->$arg_name = arr_get(
                $keyword_args,
                $arg_name,
                arr_get($arg_config['defaults'], $arg_name, $default_value)
            );
        }
    }

    protected function render_classes() {
        return implode(' ', $this->classes);
    }

    protected function render_attrs() {
        return implode(' ', array_map(
            function($key, $value) {
                return $key.'="'.$value.'"';
            },
            array_keys($this->attrs),
            array_values($this->attrs)
        ));
    }

}
