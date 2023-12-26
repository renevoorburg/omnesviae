<header id="menu-bar">
    <h1>OmnesViae</h1>
    <nav>
        <ul>
            {foreach from=$menuItems key=page item=name}
                <li class="{if $page == $currentPage}active{/if}"><a href="{$page}">{$name}</a></li>
            {/foreach}
        </ul>
    </nav>
</header>