{extends file="base.tpl"}

{block name=body}
    <div class="grid-container">
        <div class="sidenote"><h1>The OmnesViae route planner</h1></div>
        <div class="paragraph">
            <p>OmnesViae is a <a href="/">route planner for the Roman Empire</a>, based on historical data.
                Its main source is a (medieval copy of) a Roman map, known as the <a href="/tabula">Tabula Peutingeriana</a> (TP), showing the <em>cursus publicus</em>, the road network of the Roman Empire.
                Since the western most part of the map has been lost, places and routes in that part of the empire are from the <em>Antonine Itinerary</em> (Itinerarium Antonini).<br />
                The shortest route is calculated using the distances mentioned in these antique sources.
            </p>
        </div>
        <div class="sidenote"><h2>navigate the Roman empire</h2>
            <a href="https://www.buymeacoffee.com/omnesviae" target="_blank" rel="noopener noreferrer nofollow">
                <img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" class="bmc" />
            </a>
            <p>OmnesViae is free to use, but if you like it, please consider buying me a coffee.</p>
        </div>
        <div class="paragraph"><img src="/images/omnesviae_og.jpg" alt="a Roman soldier standing on a road, navigating the road network using an iPad"></div>
        <div class="sidenote">
            <h2>participate</h2>
        </div>
        <div class="paragraph">
            <p>The data source for the route planner and the displayed road network is a JSON-LD file at <a href="/data/omnesviae.json">https://omnesviae.org/data/omnesviae.json</a>.
                You can download this file, edit it to match your interpretation of the TP, and then load it into OmnesViae by pointing the <strong>?datasource</strong> parameter to it.
                For example, use <a href="https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json<">https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json</a>, to load the default definition.
                See <a href="https://github.com/renevoorburg/omnesviae">GitHub</a> for more information.
            </p>
            <p>The OmnesViae source code is available on <a href="https://github.com/renevoorburg/omnesviae">GitHub</a> under a open source license.</p>
        </div>
        <div class="sidenote">
            <h2>honori, quem honor meretur</h2>
        </div>
        <div class="paragraph">
            <p>OmnesViae was created by <a href="https://www.linkedin.com/in/rené-voorburg-aa54a93/">René Voorburg</a>. Most data behind OmnesViae is based on Richard Talbert's scholarly work on the TP, <a href="https://www.cambridge.org/us/talbert/">Rome's World: The Peutinger Map Reconsidered</a>.
                The identification of the locations of the places is largely based on data from the <a href="http://pleiades.stoa.org/">Pleiades project</a> and on Martin Weber's <a href="https://tabula-peutingeriana.de/">Tabvla Pevtingeriana</a>.<br />
                OmnesViae does add a few connections over sea that don't appear on the TP (recognizable by the dashed lines).<br />
                Many helped me with translations in the first version of OmnesViae, that existed from 2011 to 2024.
                This version of OmnesViae is a complete rewrite of the original. Support from AI tools was used for the illustration on this page and the translations.
            </p>
        </div>
        <div class="paragraph">
            <p><em>René Voorburg, January 2024</em><br />
                voorburg (at) xs4all.nl
            </p>
        </div>
    </div>

{/block}