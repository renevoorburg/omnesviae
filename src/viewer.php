<?php

$tabulaUri = $_ENV['TABULA_URI'] ?? 'https://iiif.omnesviae.org/image/peutinger.tiff/info.json';

?><!DOCTYPE html>
<html lang="la">
<head>
    <title>Tabula Peutingeriana</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/openseadragon@4.1/build/openseadragon/openseadragon.min.js"></script>
    <style>

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #openseadragon {
            width: 100vw;
            height: 100vh;
            border: none;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

<div id="openseadragon"></div>

<script>
    var viewer = OpenSeadragon({
        id: "openseadragon",
        prefixUrl: "https://cdnjs.cloudflare.com/ajax/libs/openseadragon/2.4.2/images/",
        tileSources: "<?= $tabulaUri ?>",
        defaultZoomLevel: 1,
        navigationControlAnchor: OpenSeadragon.ControlAnchor.TOP_RIGHT,
        showFullPageControl: false,
        showHomeControl: false,
    });

    // zoom to Rome
    // from https://stackoverflow.com/questions/63037117/using-openseadragon-how-can-set-it-to-load-the-image-at-a-specific-set-of-coord
    viewer.addHandler('open', function() {
        var tiledImage = viewer.world.getItemAt(0);
        var xPos = 0.336 * tiledImage.getContentSize().x;
        var yPos = 0.33 * tiledImage.getContentSize().y;
        var imageRect = new OpenSeadragon.Rect(xPos, yPos, 1000, 1000);
        var viewportRect = tiledImage.imageToViewportRectangle(imageRect);
        viewer.viewport.fitBounds(viewportRect, true);
    });

</script>

</body>
</html>
