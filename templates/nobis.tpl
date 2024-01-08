{extends file="base.tpl"}

{block name=body}
    <div class="grid-container">
        <div class="sidenote"><h1>The OmnesViae route planner</h1></div>
        <div class="paragraph">
            <p>OmnesViae is a <a href="/">route planner for the Roman Empire</a>, based on historical data.
                Its main source is a (medieval copy of) a Roman map, known as the <a href="/tabula">Tabula Peutingeriana</a> (TP), showing the <em>cursus publicus</em>, the road network of the Roman Empire.
                Since the western most part of the map has been lost, places and routes in that part of the empire are from the <em>Antonine Itinerary</em> (Itinerarium Antonini).
                Routes are calculated using the distances mentioned in the antique sources.
            </p>
        </div>
        <div class="sidenote"><h2>navigating the empire</h2></div>
        <div class="paragraph"><img src="/images/omnesviae_og.jpg" alt="Descriptive Alt Text"></div>
        <div class="sidenote"><h2>participate</h2></div>
        <div class="paragraph">
            <p>The OmnesViae code is available on <a href="">GitHub</a> under a open source license. </p>
        </div>
        <div class="sidenote"><h2>honori, quem honor meretur</h2></div>
        <div class="paragraph">
            <p>OmnesViae was created by René Voorburg. Most data behind OmnesViae is based on Richard Talbert's work on the TP, <a href="https://www.cambridge.org/us/talbert/">Rome's World: The Peutinger Map Reconsidered</a>.
                The identification of the locations of the places is largely based on the <a href="http://pleiades.stoa.org/">Pleiades project</a> and on Martin Weber's <a href="https://tabula-peutingeriana.de/">Tabvla Pevtingeriana</a>.
                OmnesViae does add a few connections over sea that dont appear on the TP. These can be recognized by the dashed lines.
                Many helped me with the translations in the first version of OmnesViae that existed from 2011 to 2024.
                This version of OmnesViae is a complete rewrite of the original version. AI was used for the illustration on this page and the translations.
            </p>
        </div>
    </div>


{/block}