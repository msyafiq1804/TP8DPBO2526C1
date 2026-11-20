<?php

class Template
{
    private $filename = '';
    private $content = '';

    public function __construct($filename = '')
    {
        $this->filename = $filename;
        $this->content = file_get_contents($filename);
    }

    public function replace($old = '', $new = '')
    {
        if (is_int($new)) {
            $value = sprintf("%d", $new);
        } elseif (is_float($new)) {
            $value = sprintf("%f", $new);
        } else {
            $value = $new;
        }

        $this->content = str_replace($old, $value, $this->content);
    }

    public function write()
    {
        echo $this->content;
    }
}