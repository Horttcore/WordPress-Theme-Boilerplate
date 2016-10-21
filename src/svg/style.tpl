/**
 * Global icon style
 */
icon( val )
	if val == 'after'
		&:after
			background url("../images/sprite.css.png") no-repeat
			background url("../images/sprite.css.svg") no-repeat, none
			background-repeat no-repeat
			content ''
			display inline-block
			vertical-align middle
	else
		&:before
			background url("../images/sprite.css.png") no-repeat
			background url("../images/sprite.css.svg") no-repeat, none
			background-repeat no-repeat
			content ''
			display inline-block
			vertical-align middle
{{#shapes}}
/**
 * Icon: {{name}}
 */
{{name}}( val = 'before' )
	icon( val )
	if val == 'after'
		&:after
			background-position {{position.relative.xy}}
			height {{height.outer}}px
			width {{width.outer}}px
	else
		&:before
			background-position {{position.relative.xy}}
			height {{height.outer}}px
			width {{width.outer}}px

.{{name}}
	{{name}}()



{{/shapes}}
