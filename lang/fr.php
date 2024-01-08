<?php

$data = array(
    "/" => array (
        "title"
        => "OmnesViae: Planificateur d'itinéraire Romain",
        "description"
        => "Planifiez votre voyage comme un Romain, avec un planificateur d'itinéraire basé sur les sources romaines, la carte routière Tabula Peutingerina et le guide de voyage d'Antoninus.",
        "keywords"
        => "Planificateur d'itinéraire romain, carte routière romaine, Tabula Peutingeriana, Itinerarium Antonini, guide de voyage romain, itinéraire de voyage romain, routes romaines, carte routière romaine, planificateur de route romaine, itinéraire routier romain, planificateur d'itinéraire routier romain, itinerarium, Antoninus"
    ),
    "/tabula" => array (
        "title"
        => "OmnesViae: Tabula Peutingeriana",
        "description"
        => "Consultez la Tabula Peutingeriana, une copie médiévale d'une longue carte routière romaine de l'Empire Romain.",
        "keywords"
        => "Tabula Peutingeriana, IIIF, carte routière romaine, routes romaines, carte routière romaine",
    ),
    "/nobis" => array (
        "title"
        => "Le planificateur d'itinéraires OmnesViae",
        "description"
        => "À propos de OmnesViae.org et de l'utilisation du site web.",
        "keywords"
        => "OmnesViae, utilisation, contexte, créateurs, droits, dons, github, René Voorburg",
        "intro"
        => "OmnesViae est un <a href=\"/\">planificateur d'itinéraires pour l'Empire Romain</a>, basé sur des données historiques.
            Sa principale source est une copie médiévale d'une carte romaine, connue sous le nom de <a href=\"/tabula\">Tabula Peutingeriana</a> (TP), montrant le <em>cursus publicus</em>, le réseau routier de l'Empire Romain.
            Comme la partie la plus à l'ouest de la carte a été perdue, les lieux et itinéraires dans cette partie de l'empire proviennent de l'<em>Itinéraire d'Antonin</em> (Itinerarium Antonini).<br />
            L'itinéraire le plus court est calculé en utilisant les distances mentionnées dans ces sources antiques.",
        "subtitle"
        => "naviguer dans l'empire romain",
        "donate"
        => "OmnesViae est gratuit à utiliser, mais si vous l'aimez, veuillez envisager de m'acheter un café.",
        "participate"
        => "participer",
        "datasource"
        => "La source de données pour le planificateur d'itinéraires et le réseau routier affiché est un fichier JSON-LD à <a href=\"/data/omnesviae.json\">https://omnesviae.org/data/omnesviae.json</a>.
            Vous pouvez télécharger ce fichier, le modifier pour correspondre à votre interprétation de la TP, puis le charger dans OmnesViae en pointant le paramètre <strong>?datasource</strong> vers celui-ci.
            Par exemple, utilisez <a href=\"https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json\">https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json</a> pour charger la définition par défaut.
            Voir <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> pour plus d'informations.",
        "sourcecode"
        => "Le code source de OmnesViae est disponible sur <a href=\"https://github.com/renevoorburg/omnesviae\">GitHub</a> sous une licence open source.",
        "credits"
        => "OmnesViae a été créé par <a href=\"https://www.linkedin.com/in/rené-voorburg-aa54a93/\">René Voorburg</a>. 
            La plupart des données derrière OmnesViae sont basées sur le travail académique de Richard Talbert sur la TP, <a href=\"https://www.cambridge.org/us/talbert/\">Rome's World: The Peutinger Map Reconsidered</a>.
            L'identification des emplacements des lieux est largement basée sur des données du <a href=\"http://pleiades.stoa.org/\">Projet Pleiades</a> et sur l'œuvre de Martin Weber <a href=\"https://tabula-peutingeriana.de/\">Tabvla Pevtingeriana</a>.<br />
            OmnesViae ajoute quelques connexions maritimes qui n'apparaissent pas sur la TP (reconnaissables par les lignes pointillées).<br />
            Beaucoup m'ont aidé avec les traductions dans la première version de OmnesViae, qui existait de 2011 à 2024.
            Cette version de OmnesViae est une réécriture complète de l'originale.
            Le soutien d'outils d'IA a été utilisé pour l'illustration sur cette page et les traductions."
    )
);
