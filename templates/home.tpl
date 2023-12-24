{extends file="base.tpl"}


{block name=libraries}
<script src="https://cdn.jsdelivr.net/npm/ol@v8.1.0/dist/ol.js"></script>
{/block}


{block name=stylesheets}
<link rel="stylesheet" href="/css/omnesviae.css" type="text/css">
<link rel="stylesheet" href="/css/ol.css" type="text/css">
{/block}


{block name=body}
    <div id="route" class="routebox">
        <div id="handle" onclick="moveRoutebox()"></div>
        <h2>Iter vestrum</h2>
        <form action="#" method="get">
            <div class="autocomplete-container">
                <label for="place1">Origo:</label><br>
                <input type="text" id="place1" name="place1" required autocomplete="off"
                       oninput="handleInput(this.value, 'place1', 'place1Value')">
                <div id="suggestions-place1" class="suggestions"></div>
                <input type="hidden" id="place1Value" name="place1Value">
            </div>
            <br>
            <div class="autocomplete-container">
                <label for="place2">Destinatio:</label><br>
                <input type="text" id="place2" name="place2" required autocomplete="off"
                       oninput="handleInput(this.value, 'place2', 'place2Value')">
                <div id="suggestions-place2" class="suggestions"></div>
                <input type="hidden" id="place2Value" name="place2Value">
            </div>
            <br>
            <input type="submit" id="submitBtn" value=" Iter Faciam " disabled>
        </form>
        <div id="results-container"></div>
        <div>
            <h3>Explicatio clavium</h3>
            <ul id="legenda">
                <li><img src="/images/symbols/0.png"> fons Tabula Peutingeriana</li>
                <li><img src="/images/symbols/1.png"> fons principalis Itinerarium Antonini</li>

            </ul>
        </div>
    </div>
    <div id="map" class="map"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer">X</a>
        <div id="popup-content"></div>
    </div>

    <script src="/js/map.js"></script>
    <script src="/js/routeform.js"></script>

{/block}