<?php

namespace RogerBCA\CoreForm;

class Form
{
    private $utms_fields = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid'];
    private $fields_array = [];
    private $fields_required_array = [];

    public function fields($fields)
    {
        $this->fields_array = array_keys($fields);
        foreach ($fields as $k => $type) {
            if ($type == 'required') {
                $this->fields_required_array[] = $k;
            }
        }
    }

    public function valid()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fields_post = array_keys($_POST);
            $errors_count = 0;
            foreach ($this->fields_required_array as $val) {
                $errors_count += $this->checkdata($val, $_POST) ? 0 : 1;
            }
            return $errors_count > 0 ? false : true;
        } else {
            return false;
        }
    }

    public function dataPOST()
    {
        $nuevo = [];
        $original = array_map([$this, 'cleardata'], $_POST);
        $fields = array_merge($this->fields_array, $this->utms_fields);
        return array_intersect_key($original, array_flip($fields));
    }

    function cleardata($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function checkdata($key, $array)
    {
        return array_key_exists($key, $array) && $array[$key] != '';
    }

    public function utmsHTML()
    {
        $inputUTMs = '';
        $get_val = array_map([$this, 'cleardata'], $_GET);

        foreach ($this->utms_fields as $key) {
            $val = array_key_exists($key, $_GET) ? $get_val[$key] : '';
            $inputUTMs .= '<input type="hidden" name="' . $key . '" value="' . $val . '" no>';
        }
        return $inputUTMs;
    }
}
