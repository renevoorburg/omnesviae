// displaying and managing the openlayers map
let storedZoom = 7.8;

function intToLatin(num) {
    const latinNumerals = {
        1: "unus",
        2: "duo",
        3: "tres",
        4: "quattuor",
        5: "quinque",
        6: "sex",
        7: "septem",
        8: "octo",
        9: "novem",
        10: "decem",
        11: "undecim",
        12: "duodecim",
        13: "tredecim",
        14: "quattuordecim",
        15: "quindecim",
        16: "sedecim",
        17: "septendecim",
        18: "duodeviginti",
        19: "undeviginti",
        20: "viginti",
        30: "triginta",
        40: "quadraginta",
        50: "quinquaginta",
        60: "sexaginta",
        70: "septuaginta",
        80: "octoginta",
        90: "nonaginta",
        100: "centum",
        200: "ducenti",
        300: "trecenti",
        1000: "mille"
    };

    if (latinNumerals[num]) {
        return latinNumerals[num]; // Directe match
    } else if (num < 100) {
        // Getallen kleiner dan 100
        const tens = Math.floor(num / 10) * 10;
        const units = num % 10;
        if (units === 1) {
            return latinNumerals[tens] + " unus"; // Speciale regel voor eenheden van 1
        }
        return latinNumerals[tens] + (units ? " " + latinNumerals[units] : "");
    } else if (num <= 199) {
        // Getallen tussen 101 en 199
        const remainder = num % 100;
        if (remainder >= 11 && remainder <= 19) {
            return "centum " + intToLatin(remainder); // Gebruik de 'teen'-regels
        } else if (remainder) {
            return "centum " + intToLatin(remainder);
        }
        return "centum"; // Exact 100
    } else if (num <= 399) {
        // Getallen tussen 200 en 399
        const hundreds = Math.floor(num / 100) * 100;
        const remainder = num % 100;
        return latinNumerals[hundreds] + (remainder ? " " + intToLatin(remainder) : "");
    } else {
        return "numerus nimis magnus"; // Limiet op 399
    }
}

function intToRoman(num) {
    if (typeof num !== 'number') return false;
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

function formatMiliaPassuum(distance) {
    return distance === 1 ? "mille passus" : `${intToRoman(distance)} milia passuum`;
}

function formatDies(days) {
    return days === 1 ? "uno die" : `${intToLatin(days)} diebus`;
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
        // Bereken totale afstand
        let totalDistance = 0;
        for (const routePart of routeData.route) {
            if (routePart.dist && routePart.dist.numeral) {
                totalDistance += routePart.dist.numeral;
            }
        }
        
        // Bereken aantal reisdagen (25 eenheden per dag)
        const daysNeeded = Math.ceil(totalDistance / 25);
        
        htmlString += `<p class="route-info">Longitudo itineris est ${formatMiliaPassuum(totalDistance)}, quod iter ${formatDies(daysNeeded)} confici potest.</p>`;
        htmlString += '<p>Iter per haec loca procedit:</p>';
        htmlString += '<ul>';
        let previousPlace = null;
        for (const routePart of routeData.route) {
            if (previousPlace !== null) {
                // let distanceNumber = getDistanceNumber(previousPlace, place);
                let distanceNumber = routePart.dist.numeral;
                // let distance = getDistance(previousPlace, place);
                // let unit = routePart.dist.possibleUnit ? routePart.dist.possibleUnit : '';
                if (distanceNumber && routePart.dist.isReconstructed) {
                    htmlString += `<li class="distance"><span class="estimated">${intToRoman(distanceNumber)}. mensura aestimata</span></li>`;
                } else if (distanceNumber) {
                    htmlString += `<li class="distance">${intToRoman(distanceNumber)}.</li>`;
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
    const name = feature.get('name')
    let content = `<h2>${name}</h2>`;
    if (placeId.charAt(0) === 'T') {
        content += `<img src="/images/TPP/${placeId}.jpg">`
    }
    const description = getPropertyById(placeId, 'description') || ' &nbsp;&nbsp;&nbsp;&nbsp; ';
    content += `<p><img class="origodest" onclick="setFrom('${placeId}', '${name}')" src="/images/origo.png">&nbsp;${description}&nbsp;<img class="origodest" onclick="setTo('${placeId}', '${name}')"  src="/images/destinatio.png"></p>`;

    popupOverlay.setPosition(coordinates);
    document.getElementById('popup-content').innerHTML = content;
    window.location = `#${placeId}`;
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
        url: `/api/geofeatures${datasourceQueryParam}`
    }),
    style: getFeatureStyle,
    zIndex: 2
});

// Process the URI request, when we have the GeoJSON data ready:
geojson.getSource().on('change', function (event) {
    if (event.target.getState() === 'ready') {
        let query = window.location.hash.substring(1);
        // we don't really check the syntax, other than route vs place request:
        let placeIds = query.split("_");
        if (placeIds.length === 2) {
            console.log('2');
            setFrom(placeIds[0], getPropertyById(placeIds[0], 'name'));
            setTo(placeIds[1], getPropertyById(placeIds[1], 'name'));
            getRoute();
        } else if (placeIds.length === 1 && placeIds[0].length > 0) {
            showPlace(placeIds[0]);
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
