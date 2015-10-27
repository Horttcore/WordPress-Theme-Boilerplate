/**
 * Global icon style
 */
icon()
    &:before
        background-image url("../images/sprites/svg/sprite.png")
        background-image url("../images/sprites/svg/sprite.svg"), none
        background-repeat no-repeat
        background-size {relWidth}em {relHeight}em
        content ''
        display inline-block
        font-size .625rem
        vertical-align middle
{#common}

.icon {
    &:before {
        icon()
    }
}
{/common}

{#svg}
/**
 * Icon: {name}
 */
{common}-{name}()
    icon()
    background-position {relPositionX}em {relPositionY}em
    width {relWidth}em
    height {relHeight}em

.{common}-{name} {
    &:before {
        @extend .icon
        {common}-{name}()
    }
}
{/svg}
