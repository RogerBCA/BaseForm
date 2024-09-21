<?php

namespace RogerBCA\CoreForm;

use RogerBCA\CoreForm\DotEnv;

class ClassCoreForm
{
    public function loadFileEnv($path)
    {
        (new DotEnv($path))->load();
    }
}
