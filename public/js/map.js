
// displaying and managing the openlayers map
let storedZoom = 7.8;

function integerToRoman(num) {
    if (typeof num !== 'number')
        return false;

    let digits = String(+num).split(""),
        key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
            "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
            "","I","II","III","IV","V","VI","VII","VIII","IX"],
        roman_num = "",
        i = 3;
    while (i--)
        roman_num = (key[+digits.pop() + (i * 10)] || "") + roman_num;
    return Array(+digits.join("") + 1).join("M") + roman_num;
}

function showRouteOnMap(routeData) {
    const routePoints = routeData.route.map(routePart => ({
        id: routePart.to,
        coords: getCoordinatesById(routePart.to),
        dist: routePart.dist
    })).filter(obj => obj.coords !== null);

    routeVectorSource.clear();
    if (routePoints.length > 1) {
        const routeLineStringFeature = new ol.Feature({
            geometry: new ol.geom.LineString(routePoints.map(obj => obj.coords)),
        });
        routeVectorSource.addFeature(routeLineStringFeature);
        map.getView().fit(routeLineStringFeature.getGeometry(), {
            padding: [30, 30, 30, 50],
            duration: 1500,
            maxZoom: 12
        });
    }
    showRoutelist(routeData);
}


function showRoutelist(routeData) {
    const resultBox = document.getElementById("results-container");
    let htmlString = '<br><h2>Iter brevissimum</h2>';

    if (routeData.route.length === 0) {
        htmlString += '<p>Nullum iter est.</p>';
    } else {
        htmlString += '<p>Iter facere potes per:</p>';
        htmlString += '<ul>';
        let previousPlace = null;
        for (const routePart of routeData.route) {
            if (previousPlace !== null) {
                // let distanceNumber = getDistanceNumber(previousPlace, place);
                let distanceNumber = routePart.dist.numeral;
                // let distance = getDistance(previousPlace, place);
                let unit = routePart.dist.possibleUnit ? routePart.dist.possibleUnit : '';
                if (distanceNumber && routePart.dist.isReconstructed) {
                    htmlString += `<li class="distance"><span class="estimated">${integerToRoman(distanceNumber)}. mensura aestimata</span></li>`;
                } else if (distanceNumber) {
                    htmlString += `<li class="distance">${integerToRoman(distanceNumber)}.</li>`;
                } else {
                    htmlString += `<li class="distance"><span class="estimated">[sine mensura]</span></li>`;
                }
                if (routePart.dist.crossesRiver) {
                    htmlString += `<li class="extra">${routePart.dist.crossesRiver}</li>`;
                }
                if (routePart.dist.crossesMountains) {
                    htmlString += `<li class="extra">per montes</li>`;
                }
            }
            previousPlace = routePart.to;
            // let placeName = getPropertyById(place, 'name');
            let symbolChar = getSymbolChar(routePart.to);
            let placeName = getPropertyById(routePart.to, 'name');
            if (!placeName) {
                placeName = '<span class="estimated">[sine nomine]</span>';
            }
            htmlString += `<li class="symbol${symbolChar}"><span onclick="showPlace('${routePart.to}')">${placeName}</span></li>`;
        }
        htmlString += '</ul>';
    }
    resultBox.innerHTML = htmlString
}

function showPlace(placeId) {
    if (!popupOverlay.getPosition()) {
        storedZoom = map.getView().getZoom();
    }

    const coordinates = getCoordinatesById(placeId);
    if (coordinates !== null) {
        map.getView().animate({
            center: coordinates,
            duration: 1500,
            zoom: 11
        });
    }

    const feature = getFeatureById(placeId);
    let content = '<h2>' + feature.get('name') + '</h2>';
    if (placeId.charAt(0) === 'T') {
        content += '<img src="/images/TPP/' + placeId + '.jpg">';
    }
    const description = getPropertyById(placeId, 'description') || ' &nbsp;&nbsp;&nbsp;&nbsp; ';
    content += '<p><img class="origodest" src="/images/origo.png">&nbsp;' + description + '&nbsp;<img class="origodest" src="/images/destinatio.png"></p>';

    popupOverlay.setPosition(coordinates);
    document.getElementById('popup-content').innerHTML = content;
    window.location = '#' + placeId;
}

function getSymbolChar(id) {
    const allowedSymbolChars = ['0', '1', 'A', 'B', 'C', 'D', 'E', 'F', 'Q'];
    const defaultSymbolChar = id.charAt(0) === 'O' ? '1' : '0';
    const symbol = getPropertyById(id, 'symbol') || defaultSymbolChar
    const symbolChar = symbol.charAt(0);
    return allowedSymbolChars.includes(symbolChar) ? symbolChar : defaultSymbolChar;
}

function getFeatureById(id) {
    const features = geojson.getSource().getFeatures();
    for (const feature of features) {
        const properties = feature.getProperties();
        if (properties.id === id) {
            return feature;
        }
    }
    return null;
}

function getPropertyById(id, property) {
    const feature = getFeatureById(id);
    if (feature != null) {
        const properties = feature.getProperties();
        if (properties.hasOwnProperty(property)) {
            return properties[property];
        }
    }
    return null;
}

function getCoordinatesById(id) {
    const feature = getFeatureById(id);
    if (feature != null) {
        const geometry = feature.getGeometry();
        return geometry.getCoordinates();
    }
    return null;
}

function getFeatureStyle(feature) {
    const id = feature.get('id');
    const symbolChar = getSymbolChar(id);
    const iconPath = `/images/symbols/${symbolChar}.png`;
    const lineColor = feature.get('extrapolated') === true ? 'rgba(180, 54, 54, 0.5)' : 'rgba(180, 54, 54, 1)';
    const lineDash = feature.get('overWater') === true ? [10, 10] : null;

    return new ol.style.Style({
        image: new ol.style.Icon({
            src: iconPath,
            anchor: [0.5, 0.5],
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            opacity: 1,
            scale: 1.0,
        }),
        stroke: new ol.style.Stroke({
            color: lineColor,
            lineDash: lineDash,
            width: 3,
        }),
    });
}

// Overlay to display the popup
const popupOverlay = new ol.Overlay({
    element: document.getElementById('popup'),
    autoPan: true,
    autoPanAnimation: {
        duration: 250
    }
});

const geojson = new ol.layer.Vector({
    source: new ol.source.Vector({
        format: new ol.format.GeoJSON(),
        url: '/api/geofeatures'
    }),
    style: getFeatureStyle,
    zIndex: 2
});

geojson.getSource().on('change', function (event) {
    if (event.target.getState() === 'ready') {
        const place1 = window.location.hash.substring(1);
        if (place1) {
            showPlace(place1);
        }
    }
});


// Initialize the map
const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM() // OpenStreetMap as the tile source
        }),
        geojson
    ],
    overlays: [popupOverlay],
    view: new ol.View({
        center: ol.proj.fromLonLat([12.5, 41.9]), // Center of the map, lon/lat
        zoom: 7.8 // Initial zoom level
    })
});

// Create vector source and layer outside showRouteOnMap, so that it's not re-created every time
const routeVectorSource = new ol.source.Vector();
const routeVectorLayer = new ol.layer.Vector({
    source: routeVectorSource,
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'rgb(255, 255, 0, 0.5)', // Change this to the desired color
            width: 9, // Change this to the desired width
        }),
    }),
    zIndex: 1
});
map.addLayer(routeVectorLayer);

// Popup closer
const closer = document.getElementById('popup-closer');
closer.onclick = () => {
    hidePopup();
    return false;
};

function hidePopup() {
    popupOverlay.setPosition(undefined);
    closer.blur();
    window.location = '#';
    map.getView().animate({
        zoom: storedZoom,
    }, {
        duration: 1000,
    });
}

// Display popup on click
map.on('click', function (event) {
    const feature = map.forEachFeatureAtPixel(event.pixel, function (feature) {
        return feature;
    });
    if (feature && feature.getGeometry().getType() === 'Point') {
        showPlace(feature.get('id'));
    }
});

// Set pointer cursor when hovering over a point feature
map.on('pointermove', function (event) {
    const pixel = map.getEventPixel(event.originalEvent);
    const feature = map.forEachFeatureAtPixel(pixel, function (feature) {
        return feature;
    });
    if (feature && feature.getGeometry().getType() === 'Point') {
        map.getTargetElement().style.cursor = 'pointer';
    } else {
        map.getTargetElement().style.cursor = '';
    }
});

