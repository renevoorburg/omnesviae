<?php

namespace OmnesViae\Templating;

use Smarty\Smarty;

class Page extends Smarty
{

    private $menuItems = [
        '/' => 'Iter',
        '/tabula' => 'Tabula',
        '/nobis' => 'De Nobis'
    ];


    public function __construct(string $page = "/", string $language = 'en')
    {
        parent::__construct();
        $this->setTemplateDir(__DIR__ . '/../../templates');
        $this->setCompileDir(__DIR__ . '/../../templates_c');
        $this->setCacheDir(__DIR__ . '/../../cache');
        $this->setConfigDir(__DIR__ . '/../../configs');

        $this->assign('currentPage', $page);
        $this->assign('menuItems', $this->menuItems);

        $this->assign('lang',$language);

        $translations = new \OmnesViae\Translations($page, $language);
        foreach ($translations as $key => $value) {
            $this->assign($key, $value);
        }


    }

    public function display($template = 'base.tpl', $cache_id = null, $compile_id = null, $parent = null)
    {
        parent::display($template, $cache_id, $compile_id, $parent);
    }

}