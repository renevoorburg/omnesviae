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
        => "Il pianificatore di rotte OmnesViae",
        "description"
        => "Informazioni su OmnesViae.org e sull'uso del sito web.",
        "keywords"
        => "OmnesViae, utilizzo, background, creatori, diritti, donazioni, github, René Voorburg",
        "intro"
        => "OmnesViae è un <a href=\"/\">pianificatore di rotte per l'Impero Romano</a>, basato su dati storici.
            La sua fonte principale è una copia medievale di una mappa romana, nota come <a href=\"/tabula\">Tabula Peutingeriana</a> (TP), che mostra il <em>cursus publicus</em>, la rete stradale dell'Impero Romano.
            Poiché la parte più occidentale della mappa è andata perduta, i luoghi e le rotte in quella parte dell'impero provengono dall'<em>Itinerario di Antonino</em> (Itinerarium Antonini).<br />
            Il percorso più breve viene calcolato utilizzando le distanze menzionate in queste fonti antiche.",
        "subtitle"
        => "naviga nell'impero romano",
        "donate"
        => "OmnesViae è gratuito, ma se ti piace, considera di offrirmi un caffè.",
        "participate"
        => "partecipa",
        "datasource"
        => "La fonte dei dati per il pianificatore di rotte e la rete stradale visualizzata è un file JSON-LD su <a href=\"/data/omnesviae.json\">https://omnesviae.org/data/omnesviae.json</a>.
            Puoi scaricare questo file, modificarlo per adattarlo alla tua interpretazione della TP e poi caricarlo su OmnesViae puntando il parametro <strong>?datasource</strong> verso di esso.
            Ad esempio, usa <a href=\"/?datasource=https://omnesviae.org/data/omnesviae.json\">https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json</a> per caricare la definizione predefinita.
            Consulta <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> per maggiori informazioni.",
        "sourcecode"
        => "Il codice sorgente di OmnesViae è disponibile su <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> sotto una licenza open source.",
        "credits"
        => "OmnesViae è stato creato da <a href=\"https://www.linkedin.com/in/rené-voorburg-aa54a93/\">René Voorburg</a>. 
            La maggior parte dei dati dietro OmnesViae si basa sul lavoro accademico di Richard Talbert sulla TP, <a href=\"https://www.cambridge.org/us/talbert/\">Rome's World: The Peutinger Map Reconsidered</a>.
            L'identificazione delle località è basata in gran parte sui dati del <a href=\"http://pleiades.stoa.org/\">Progetto Pleiades</a> e sul lavoro di Martin Weber <a href=\"https://tabula-peutingeriana.de/\">Tabvla Pevtingeriana</a>. Una risorsa preziosa per la ricerca sulla Tabula è la <a href='https://www.ku.de/ggf/geschichte/alte-geschichte/forschung/datenbank-tp-online'>Datenbank tp-online</a>.<br />
            OmnesViae aggiunge alcune connessioni marittime che non compaiono sulla TP (riconoscibili dalle linee tratteggiate).<br />
            Molti mi hanno aiutato con le traduzioni nella prima versione di OmnesViae, esistita dal 2011 al 2024.
            Questa versione di OmnesViae è una riscrittura completa dell'originale.
            È stato utilizzato il supporto di strumenti di intelligenza artificiale per l'illustrazione in questa pagina e le traduzioni."
    )
);
