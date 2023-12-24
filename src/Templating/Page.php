<?php

namespace OmnesViae\Templating;

class Page extends \Smarty
{

    private $menuItems = [
        '/' => 'Iter',
        '/tabula' => 'Tabula',
        '/nobis' => 'De Nobis'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->setTemplateDir(__DIR__ . '/../../templates');
        $this->setCompileDir(__DIR__ . '/../../templates_c');
        $this->setCacheDir(__DIR__ . '/../../cache');
        $this->setConfigDir(__DIR__ . '/../../configs');

        $this->assign('menuItems', $this->menuItems);
    }

    public function display($template = 'base.tpl', $cache_id = null, $compile_id = null, $parent = null)
    {
        parent::display($template, $cache_id, $compile_id, $parent);
    }

}