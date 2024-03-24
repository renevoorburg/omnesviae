<!DOCTYPE html>
<html lang="{$lang}">
    <head>
        <title>{$title}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="description" content="{$description}" />
        <meta name="keywords" content="{$keywords}" />

        <meta property="og:image" content="/images/omnesviae_og.jpg">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="675">

        <!-- TODO hreflang stuff -->

        {block name=libraries}<!-- libraries -->{/block}
        {block name=stylesheets}<link rel="stylesheet" href="/css/omnesviae.css" type="text/css">{/block}

    </head>
    <body>
        {include file="parts/header.tpl"}
        {block name=body}Default Body{/block}
        {block name=footer}{/block}
    </body>
</html>