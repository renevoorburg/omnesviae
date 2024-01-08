<?php

$data = array(
    "/" => array (
        "title"
        => "OmnesViae: Planificador de Rutas Romano",
        "description"
        => "Planifica tu viaje como un romano, con un planificador de rutas basado en fuentes romanas, el mapa de carreteras Tabula Peutingerina y la guía de viaje de Antonino.",
        "keywords"
        => "Planificador de rutas romano, mapa de carreteras romano, Tabula Peutingeriana, Itinerarium Antonini, guía de viaje romana, ruta de viaje romana, carreteras romanas, mapa de carreteras romano, planificador de carreteras romano, ruta de carreteras romana, planificador de ruta de carreteras romano, itinerarium, Antonino"
    ),
    "/tabula" => array (
        "title"
        => "OmnesViae: Tabula Peutingeriana",
        "description"
        => "Consulta la Tabula Peutingeriana, una copia medieval de un extenso mapa de carreteras romano del Imperio Romano.",
        "keywords"
        => "Tabula Peutingeriana, IIIF, mapa de carreteras romano, carreteras romanas, mapa de carreteras romano",
    ),
    "/nobis" => array (
        "title"
        => "El planificador de rutas OmnesViae",
        "description"
        => "Acerca de OmnesViae.org y el uso del sitio web.",
        "keywords"
        => "OmnesViae, uso, antecedentes, creadores, derechos, donaciones, github, René Voorburg",
        "intro"
        => "OmnesViae es un <a href=\"/\">planificador de rutas para el Imperio Romano</a>, basado en datos históricos.
            Su principal fuente es una copia medieval de un mapa romano, conocido como la <a href=\"/tabula\">Tabula Peutingeriana</a> (TP), que muestra el <em>cursus publicus</em>, la red de carreteras del Imperio Romano.
            Dado que se ha perdido la parte más occidental del mapa, los lugares y rutas de esa parte del imperio provienen del <em>Itinerario Antonino</em> (Itinerarium Antonini).<br />
            La ruta más corta se calcula utilizando las distancias mencionadas en estas fuentes antiguas.",
        "subtitle"
        => "navegar por el imperio romano",
        "donate"
        => "OmnesViae es de uso gratuito, pero si te gusta, considera comprarme un café.",
        "participate"
        => "participar",
        "datasource"
        => "La fuente de datos para el planificador de rutas y la red de carreteras mostrada es un archivo JSON-LD en <a href=\"/data/omnesviae.json\">https://omnesviae.org/data/omnesviae.json</a>.
        Puedes descargar este archivo, editarlo para que coincida con tu interpretación de la TP y luego cargarlo en OmnesViae apuntando el parámetro <strong>?datasource</strong> a él.
        Por ejemplo, usa <a href=\"https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json\">https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json</a>, para cargar la definición predeterminada.
        Consulta <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> para más información.",
        "sourcecode"
        => "El código fuente de OmnesViae está disponible en <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> bajo una licencia de código abierto.",
        "credits"
        => "OmnesViae fue creado por <a href=\"https://www.linkedin.com/in/rené-voorburg-aa54a93/\">René Voorburg</a>. 
        La mayoría de los datos detrás de OmnesViae se basan en el trabajo académico de Richard Talbert sobre la TP, <a href=\"https://www.cambridge.org/us/talbert/\">Rome's World: The Peutinger Map Reconsidered</a>.
        La identificación de las ubicaciones de los lugares se basa en gran medida en datos del <a href=\"http://pleiades.stoa.org/\">Proyecto Pleiades</a> y en la obra de Martin Weber <a href=\"https://tabula-peutingeriana.de/\">Tabvla Pevtingeriana</a>.<br />
        OmnesViae añade algunas conexiones sobre el mar que no aparecen en la TP (reconocibles por las líneas discontinuas).<br />
        Muchos me ayudaron con las traducciones en la primera versión de OmnesViae, que existió desde 2011 hasta 2024.
        Esta versión de OmnesViae es una reescritura completa del original.
        Se utilizó el apoyo de herramientas de IA para la ilustración en esta página y las traducciones."
    )

);
