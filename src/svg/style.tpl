{#common}
[class*="{common}-"]:before {
    background-image: url("../images/sprites/svg/sprite.png");
    background-image: url("../images/sprites/svg/sprite.svg"), none;
    background-repeat: no-repeat;
    background-size: {relWidth}em {relHeight}em;
    content:' ';
    display: inline-block;
    font-size: 10px;
    vertical-align:middle;
}
{/common}

{#svg}
.{common}-{name}:before {
    background-position: {relPositionX}em {relPositionY}em;
    width: {relWidth}em;
    height: {relHeight}em;
}
{/svg}
