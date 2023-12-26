{extends file="base.tpl"}


{block name=libraries}
    <script src="/js/vendor/ruven/iipmooviewer/mootools-core-1.6.0-compressed.js"></script>
    <script src="/js/vendor/ruven/iipmooviewer/iipmooviewer-2.0-min.js"></script>
{/block}


{block name=stylesheets}
    <link rel="stylesheet" href="/css/omnesviae.css" type="text/css">
    <link rel="stylesheet" href="/css/vendor/ruven/iipmooviewer/iip.css" type="text/css">
{/block}


{block name=body}
    <div id="map" class="map"></div>

    <script>
        var server = '/fcgi-bin/iipsrv.fcgi';
        var image = 'peutinger.tiff';
        var credit = 'IIIF: http://omnesviae.org/image/peutinger.tiff';

        new IIPMooViewer( "map", {
            server: server,
            image: image,
            credit: credit,
            showCoords: true,
            navigation: {
                buttons: ['zoomIn','zoomOut','reset','rotateLeft','rotateRight']
            },
            scale: 9.24
        });
    </script>

{/block}
