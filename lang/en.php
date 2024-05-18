<?php

$data = array(
    "/" => array (
        "title"
        => "OmnesViae: Roman Route Planner",
        "description"
        => "Plan your journey like a Roman, with a route planner based on Roman sources, the road map Tabula Peutingerina, and the travel guide of Antoninus.",
        "keywords"
        => "Roman route planner, Roman road map, Tabula Peutingeriana, Itinerarium Antonini, Roman travel guide, Roman travel route, Roman roads, Roman road map, Roman road planner, Roman road route, Roman road route planner, itinerarium, Antoninus"
    ),
    "/tabula" => array (
        "title"
        => "OmnesViae: Tabula Peutingeriana",
        "description"
        => "View the Tabula Peutingeriana, a medieval copy of a meters-long Roman road map of the Roman Empire.",
        "keywords"
        => "Tabula Peutingeriana, IIIF, Roman road map, Roman roads, Roman road map",
    ),
    "/nobis" => array (
        "title"
        => "The OmnesViae route planner",
        "description"
        => "About OmnesViae.org and the use of the website.",
        "keywords"
        => "OmnesViae, usage, background, creators, rights, donations, github, René Voorburg",
        "intro"
        => "OmnesViae is a <a href=\"/\">route planner for the Roman Empire</a>, based on historical data.
                Its main source is a (medieval copy of) a Roman map, known as the <a href=\"/tabula\">Tabula Peutingeriana</a> (TP), showing the <em>cursus publicus</em>, the road network of the Roman Empire.
                Since the western most part of the map has been lost, places and routes in that part of the empire are from the <em>Antonine Itinerary</em> (Itinerarium Antonini).<br />
                The shortest route is calculated using the distances mentioned in these antique sources.",
        "subtitle"
        => "navigate the Roman empire",
        "donate"
        => "OmnesViae is free to use, but if you like it, please consider buying me a coffee.",
        "participate"
        => "participate",
        "datasource"
        => "The data source for the route planner and the displayed road network is a JSON-LD file at <a href=\"/data/omnesviae.json\">https://omnesviae.org/data/omnesviae.json</a>.
            You can download this file, edit it to match your interpretation of the TP, and then load it into OmnesViae by pointing the <strong>?datasource</strong> parameter to it.
            For example, use <a href=\"/?datasource=https://omnesviae.org/data/omnesviae.json\">https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json</a>, to load the default definition.
            See <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> for more information.",
        "sourcecode"
        => "The OmnesViae source code is available on <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> under a open source license.",
        "credits"
        => "OmnesViae was created by <a href=\"https://www.linkedin.com/in/rené-voorburg-aa54a93/\">René Voorburg</a>. 
            Most data behind OmnesViae is based on Richard Talbert's scholarly work on the TP, <a href=\"https://www.cambridge.org/us/talbert/\">Rome's World: The Peutinger Map Reconsidered</a>.
            The identification of the locations of places is largely based on data from the <a href=\"http://pleiades.stoa.org/\">Pleiades project</a> and on Martin Weber's <a href=\"https://tabula-peutingeriana.de/\">Tabvla Pevtingeriana</a>.<br />
            OmnesViae does add a few connections over sea that don't appear on the TP (recognizable by the dashed lines).<br />
            Many helped me with translations in the first version of OmnesViae, that existed from 2011 to 2024.
            This version of OmnesViae is a complete rewrite of the original. 
            Support from AI tools was used for the illustration on this page and the translations."

    )
);
