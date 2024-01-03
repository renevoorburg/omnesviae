{extends file="base.tpl"}


{block name=libraries}
<script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>
{/block}


{block name=stylesheets}
<link rel="stylesheet" href="/css/omnesviae.css" type="text/css">
<link rel="stylesheet" href="/css/ol.css" type="text/css">
{/block}


{block name=body}
    <div id="route" class="routebox">
        <div id="handle"></div>
        <h2>Iter vestrum</h2>
        <form action="#" method="get">
            <div class="autocomplete-container">
                <label for="origin">Origo:</label><br>
                <input type="text" id="origin" name="origin" required autocomplete="off">
                <div id="suggestions-origin" class="suggestions" role="listbox"></div>
                <input type="hidden" id="originId" name="origin1Id">
            </div>
            <br>
            <div class="autocomplete-container">
                <label for="destination">Destinatio:</label><br>
                <input type="text" id="destination" name="destination" required autocomplete="off">
                <div id="suggestions-destination" class="suggestions" role="listbox"></div>
                <input type="hidden" id="destinationId" name="destinationId">
            </div>
            <br>
            <input type="submit" id="submitBtn" value=" Iter Faciam " disabled>
        </form>
        <div id="results-container"></div>
        <div>
            <h3>Explicatio clavium</h3>
            <ul id="legenda">
                <li><img src="/images/symbols/0_noborder.png"> fons Tabula Peutingeriana</li>
                <li><img src="/images/symbols/1_noborder.png"> fons principalis Itinerarium Antonini</li>

            </ul>
        </div>
    </div>
    <div id="map" class="map"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer" aria-label="close button">X</a>
        <div id="popup-content"></div>
    </div>

    <script src="/js/routeform.js"></script>
    <script src="/js/map.js"></script>

{/block}