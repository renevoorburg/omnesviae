<?php

namespace OmnesViae\Templating;

class Page extends \Smarty
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplateDir(__DIR__ . '/../../templates');
        $this->setCompileDir(__DIR__ . '/../../templates_c');
        $this->setCacheDir(__DIR__ . '/../../cache');
        $this->setConfigDir(__DIR__ . '/../../configs');
//        $this->assign('app_name', 'OmnesViae');
    }

//    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
//    {
//        $this->assign('app_name', 'OmnesViae');
//        parent::display($template, $cache_id, $compile_id, $parent);
//    }


}