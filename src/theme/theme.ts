import type { ThemeJson } from './theme.d.js';

const config: ThemeJson = {
	"$schema": "https://schemas.wp.org/trunk/theme.json",
	"version": 3,
	"settings": {
		"appearanceTools": false,
		"useRootPaddingAwareAlignments": true,
		"border": {
			"color": false,
			"radius": false,
			"style": false,
			"width": false
		},
		"color": {
			"defaultDuotone": false,
			"custom": false,
			"customDuotone": false,
			"customGradient": false,
			"defaultGradients": false,
			"defaultPalette": false,
			"link": false,
			"palette": [],
			"text": false,
			"heading": false
		},
		"custom": {
			"color": {}
		},
		"dimensions": {
			"aspectRatios": [],
			"aspectRatio": true,
			"defaultAspectRatios": true
		},
		"layout": {
			"allowEditing": true,
			"contentSize": "var:custom|layout|max-width|content",
			"wideSize": "var:custom|layout|max-width|feature"
		},
		"position": {
			"sticky": false
		},
		"shadow": {
			"defaultPresets": false
		},
		"spacing": {
			"blockGap": false,
			"customSpacingSize": false,
			"defaultSpacingSizes": false,
			"units": [
				"rem",
				"%",
				"px"
			],
			"spacingSizes": []
		},
		"typography": {
			"writingMode": false,
			"customFontSize": false,
			"defaultFontSizes": false,
			"dropCap": false,
			"fluid": false,
			"fontFamilies": [
				{
					"fontFace": [
						{
							"fontFamily": "Roboto Flex",
							"fontStretch": "normal",
							"fontStyle": "normal",
							"src": [
								"file:./assets/fonts/roboto-flex-v27-latin-regular.woff2"
							]
						}
					],
					"fontFamily": "'Roboto Flex', Roboto, 'Helvetica Neue', 'Segoe UI', Oxygen-Sans, Ubuntu, Cantarell, sans-serif",
					"name": "Roboto Flex",
					"slug": "default"
				}
			],
			"fontSizes": [],
			"fontStyle": false,
			"fontWeight": false,
			"letterSpacing": false,
			"lineHeight": false,
			"textDecoration": false,
			"textTransform": false
		}
	},
	"styles": {
		"typography": {
			"fontFamily": "var:preset|font-family|default",
			"lineHeight": "normal"
		},
		"spacing": {
			"padding": {
				"right": "2rem",
				"left": "2rem"
			}
		},
		"elements": {
			"link": {
				"color": {
					"text": "inherit"
				},
				"typography": {
					"textDecoration": "underline"
				},
				":hover": {
					"typography": {
						"textDecoration": "none"
					}
				},
				":active": {
					"color": {
						"text": "inherit"
					}
				},
				":visited": {
					"color": {
						"text": "inherit"
					}
				}
			}
		}
	}
};

export default config;
