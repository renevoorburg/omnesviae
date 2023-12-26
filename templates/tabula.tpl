{extends file="base.tpl"}


{block name=libraries}
    <script src="/vendor/iipmooviewer/js/mootools-core-1.6.0-compressed.js"></script>
    <script src="/vendor/iipmooviewer/js/iipmooviewer-2.0-min.js"></script>
{/block}


{block name=stylesheets}
    <link rel="stylesheet" href="/css/omnesviae.css" type="text/css">
    <link rel="stylesheet" href="/vendor/iipmooviewer/css/iip.css" type="text/css">
{/block}


{block name=body}
    <iframe src="/viewer.html" style="height: 100%"></iframe>

{/block}
