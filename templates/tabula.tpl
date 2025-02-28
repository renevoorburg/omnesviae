{extends file="base.tpl"}

{block name=body}
    <div class="iframe-container">
        <iframe src="/viewer"></iframe>
        <div class="overlay-text">{$credits}</div>
    </div>
{/block}
