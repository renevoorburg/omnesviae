{extends file="base.tpl"}

{block name=body}
    <div class="grid-container">
        <div class="sidenote"><h1>{$title}</h1></div>
        <div class="paragraph"><p>{$intro}</p></div>
        <div class="sidenote"><h2>{$subtitle}</h2>
            <a href="https://www.buymeacoffee.com/omnesviae" target="_blank" rel="noopener noreferrer nofollow">
                <img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" class="bmc" />
            </a>
            <p>{$donate}</p>
        </div>
        <div class="paragraph"><img src="/images/omnesviae_og.jpg" alt="a Roman soldier standing on a road, navigating the road network using an iPad"></div>
        <div class="sidenote"><h2>{$participate}</h2></div>
        <div class="paragraph">
            <p>{$datasource}</p>
            <p>{$sourcecode}</p>
        </div>
        <div class="sidenote">
            <h2>honori, quem honor meretur</h2>
        </div>
        <div class="paragraph">
            <p>{$credits}</p>
        </div>
        <div class="paragraph">
            <p><em>René Voorburg, January 2024</em><br />voorburg (at) xs4all.nl</p>
        </div>
    </div>

{/block}