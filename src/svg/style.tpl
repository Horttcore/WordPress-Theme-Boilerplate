/**
 * Global icon style
 */
icon( val )

	if val == 'after'
		&:after
			background-image url("../images/sprites/svg/sprite.png")
			background-image url("../images/sprites/svg/sprite.svg"), none
			background-repeat no-repeat
			background-size {relWidth}em {relHeight}em
			content ''
			display inline-block
			font-size .625rem
			vertical-align middle
	else
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
	icon( before )
}

.icon-after {
	icon( after )
}
{/common}

{#svg}
/**
 * Icon: {name}
 */
{common}-{name}( val = 'before'  )
	icon( val )

	if val == 'after'
		&:after
			background-position {relPositionX}em {relPositionY}em
			width {relWidth}em
			height {relHeight}em
	else
		&:before
			background-position {relPositionX}em {relPositionY}em
			width {relWidth}em
			height {relHeight}em

.{common}-{name} {
	{common}-{name}()
}
{/svg}
