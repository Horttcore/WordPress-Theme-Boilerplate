/* eslint-disable */
/**
 * This file was automatically generated from theme.json schema.
 * DO NOT MODIFY IT BY HAND. Instead, modify the source schema file,
 * and run `npm run generate:theme-types` to regenerate this file.
 */

export type SettingsProperties = SettingsAppearanceToolsProperties &
	SettingsBackgroundProperties &
	SettingsBorderProperties &
	SettingsColorProperties &
	SettingsDimensionsProperties &
	SettingsLayoutProperties &
	SettingsLightboxProperties &
	SettingsPositionProperties &
	SettingsShadowProperties &
	SettingsSpacingProperties &
	SettingsTypographyProperties &
	SettingsCustomProperties;
/**
 * This interface was referenced by `SettingsBlocksPropertiesComplete`'s JSON-Schema definition
 * via the `patternProperty` "^[a-z][a-z0-9-]*\/[a-z][a-z0-9-]*$".
 */
export type SettingsPropertiesComplete = SettingsProperties & {
	[k: string]: unknown;
};
export type StylesPropertiesComplete = StylesProperties & {
	[k: string]: unknown;
};
/**
 * This interface was referenced by `StylesBlocksPropertiesComplete`'s JSON-Schema definition
 * via the `patternProperty` "^[a-z][a-z0-9-]*\/[a-z][a-z0-9-]*$".
 */
export type StylesPropertiesAndElementsComplete = StylesProperties & {
	elements?: StylesElementsPropertiesComplete;
	variations?: StylesVariationsPropertiesComplete;
	[k: string]: unknown;
} & {
	[k: string]: unknown;
};
/**
 * This interface was referenced by `StylesVariationsPropertiesComplete`'s JSON-Schema definition
 * via the `patternProperty` "^[a-z][a-z0-9-]*$".
 */
export type StylesVariationPropertiesComplete = StylesProperties & {
	elements?: StylesElementsPropertiesComplete;
	blocks?: StylesVariationBlocksPropertiesComplete;
	[k: string]: unknown;
} & {
	[k: string]: unknown;
};
/**
 * This interface was referenced by `StylesVariationBlocksPropertiesComplete`'s JSON-Schema definition
 * via the `patternProperty` "^[a-z][a-z0-9-]*\/[a-z][a-z0-9-]*$".
 */
export type StylesVariationBlockPropertiesComplete = StylesProperties & {
	elements?: StylesElementsPropertiesComplete;
	[k: string]: unknown;
} & {
	[k: string]: unknown;
};
/**
 * This interface was referenced by `StylesVariationsProperties`'s JSON-Schema definition
 * via the `patternProperty` "^[a-z][a-z0-9-]*$".
 */
export type StylesVariationProperties = StylesProperties & {
	elements?: StylesElementsPropertiesComplete;
	blocks?: StylesVariationBlocksPropertiesComplete;
	[k: string]: unknown;
} & {
	[k: string]: unknown;
};

export interface JSONSchemaForWordPressBlockThemeGlobalSettingsAndStyles {
	/**
	 * JSON schema URI for theme.json.
	 */
	$schema?: string;
	/**
	 * Version of theme.json to use.
	 */
	version: 3;
	/**
	 * Title of the styles variation. If not defined, the file name will be used.
	 */
	title?: string;
	/**
	 * Slug of the styles variation. If not defined, the kebab-case title will be used.
	 */
	slug?: string;
	/**
	 * Description of the styles variation.
	 */
	description?: string;
	/**
	 * List of block types that can use the block style variation this theme.json file represents.
	 */
	blockTypes?: string[];
	/**
	 * Settings for the block editor and individual blocks. These include things like:
	 * - Which customization options should be available to the user.
	 * - The default colors, font sizes... available to the user.
	 * - CSS custom properties and class names used in styles.
	 * - And the default layout of the editor (widths and available alignments).
	 */
	settings?: SettingsProperties & {
		/**
		 * Enables root padding (the values from `styles.spacing.padding`) to be applied to the contents of full-width blocks instead of the root block.
		 *
		 * Please note that when using this setting, `styles.spacing.padding` should always be set as an object with `top`, `right`, `bottom`, `left` values declared separately.
		 */
		useRootPaddingAwareAlignments?: boolean;
		blocks?: SettingsBlocksPropertiesComplete;
		[k: string]: unknown;
	} & {
		[k: string]: unknown;
	};
	/**
	 * Organized way to set CSS properties. Styles in the top-level will be added in the `body` selector.
	 */
	styles?: StylesProperties & {
		elements?: StylesElementsPropertiesComplete;
		blocks?: StylesBlocksPropertiesComplete;
		variations?: StylesVariationsProperties;
		[k: string]: unknown;
	} & {
		[k: string]: unknown;
	};
	/**
	 * Additional metadata for custom templates defined in the templates folder.
	 */
	customTemplates?: {
		/**
		 * Filename, without extension, of the template in the templates folder.
		 */
		name: string;
		/**
		 * Title of the template, translatable.
		 */
		title: string;
		/**
		 * List of post types that can use this custom template.
		 */
		postTypes?: string[];
	}[];
	/**
	 * Additional metadata for template parts defined in the parts folder.
	 */
	templateParts?: {
		/**
		 * Filename, without extension, of the template in the parts folder.
		 */
		name: string;
		/**
		 * Title of the template, translatable.
		 */
		title?: string;
		/**
		 * The area the template part is used for. Block variations for `header` and `footer` values exist and will be used when the area is set to one of those.
		 */
		area?: string;
	}[];
	/**
	 * An array of pattern slugs to be registered from the Pattern Directory.
	 */
	patterns?: string[];
}
export interface SettingsAppearanceToolsProperties {
	/**
	 * Setting that enables the following UI tools:
	 *
	 * - background: backgroundImage, backgroundSize
	 * - border: color, radius, style, width
	 * - color: link, heading, button, caption
	 * - dimensions: aspectRatio, minHeight, width
	 * - position: sticky
	 * - spacing: blockGap, margin, padding
	 * - typography: lineHeight
	 */
	appearanceTools?: boolean;
	[k: string]: unknown;
}
export interface SettingsBackgroundProperties {
	/**
	 * Settings related to background.
	 */
	background?: {
		/**
		 * Allow users to set a background image.
		 */
		backgroundImage?: boolean;
		/**
		 * Allow users to set values related to the size of a background image, including size, position, and repeat controls.
		 */
		backgroundSize?: boolean;
	};
	[k: string]: unknown;
}
export interface SettingsBorderProperties {
	/**
	 * Settings related to borders.
	 */
	border?: {
		/**
		 * Allow users to set custom border colors.
		 */
		color?: boolean;
		/**
		 * Allow users to set custom border radius.
		 */
		radius?: boolean;
		/**
		 * Allow users to set custom border styles.
		 */
		style?: boolean;
		/**
		 * Allow users to set custom border widths.
		 */
		width?: boolean;
		/**
		 * Border radius size presets for the border radius selector.
		 * Generates a custom property (`--wp--preset--border-radius--{slug}`) per preset value.
		 */
		radiusSizes?: {
			/**
			 * Name of the border radius size preset, translatable.
			 */
			name?: string;
			/**
			 * Unique identifier for the border raidus size preset.
			 */
			slug?: string;
			/**
			 * CSS border-radius value, including units.
			 */
			size?: string;
		}[];
	};
	[k: string]: unknown;
}
export interface SettingsColorProperties {
	/**
	 * Settings related to colors.
	 */
	color?: {
		/**
		 * Allow users to set background colors.
		 */
		background?: boolean;
		/**
		 * Allow users to select custom colors.
		 */
		custom?: boolean;
		/**
		 * Allow users to create custom duotone filters.
		 */
		customDuotone?: boolean;
		/**
		 * Allow users to create custom gradients.
		 */
		customGradient?: boolean;
		/**
		 * Allow users to choose filters from the default duotone filter presets.
		 */
		defaultDuotone?: boolean;
		/**
		 * Allow users to choose colors from the default gradients.
		 */
		defaultGradients?: boolean;
		/**
		 * Allow users to choose colors from the default palette.
		 */
		defaultPalette?: boolean;
		/**
		 * Duotone presets for the duotone picker.
		 * Doesn't generate classes or properties.
		 */
		duotone?: {
			/**
			 * Name of the duotone preset, translatable.
			 */
			name: string;
			/**
			 * Kebab-case unique identifier for the duotone preset.
			 */
			slug: string;
			/**
			 * List of colors from dark to light.
			 */
			colors: string[];
		}[];
		/**
		 * Gradient presets for the gradient picker.
		 * Generates a single class (`.has-{slug}-background`) and custom property (`--wp--preset--gradient--{slug}`) per preset value.
		 */
		gradients?: {
			/**
			 * Name of the gradient preset, translatable.
			 */
			name: string;
			/**
			 * Kebab-case unique identifier for the gradient preset.
			 */
			slug: string;
			/**
			 * CSS gradient string.
			 */
			gradient: string;
		}[];
		/**
		 * Allow users to set link colors in a block.
		 */
		link?: boolean;
		/**
		 * Color palette presets for the color picker.
		 * Generates three classes (`.has-{slug}-color`, `.has-{slug}-background-color`, and `.has-{slug}-border-color`) and a single custom property (`--wp--preset--color--{slug}`) per preset value.
		 */
		palette?: {
			/**
			 * Name of the color preset, translatable.
			 */
			name: string;
			/**
			 * Kebab-case unique identifier for the color preset.
			 */
			slug: string;
			/**
			 * CSS hex or rgb(a) string.
			 */
			color: string;
		}[];
		/**
		 * Allow users to set text colors in a block.
		 */
		text?: boolean;
		/**
		 * Allow users to set heading colors in a block.
		 */
		heading?: boolean;
		/**
		 * Allow users to set button colors in a block.
		 */
		button?: boolean;
		/**
		 * Allow users to set caption colors in a block.
		 */
		caption?: boolean;
	};
	[k: string]: unknown;
}
export interface SettingsDimensionsProperties {
	/**
	 * Settings related to dimensions.
	 */
	dimensions?: {
		/**
		 * Allow users to set an aspect ratio.
		 */
		aspectRatio?: boolean;
		/**
		 * Allow users to choose aspect ratios from the default set of aspect ratios.
		 */
		defaultAspectRatios?: boolean;
		/**
		 * Allow users to define aspect ratios for some blocks.
		 */
		aspectRatios?: {
			/**
			 * Name of the aspect ratio preset.
			 */
			name?: string;
			/**
			 * Kebab-case unique identifier for the aspect ratio preset.
			 */
			slug?: string;
			/**
			 * Aspect ratio expressed as a division or decimal.
			 */
			ratio?: string;
			[k: string]: unknown;
		}[];
		/**
		 * Allow users to set custom minimum height.
		 */
		minHeight?: boolean;
		/**
		 * Allow users to set custom width.
		 */
		width?: boolean;
	};
	[k: string]: unknown;
}
export interface SettingsLayoutProperties {
	/**
	 * Settings related to layout.
	 */
	layout?: {
		/**
		 * Sets the max-width of the content.
		 */
		contentSize?: string;
		/**
		 * Sets the max-width of wide (`.alignwide`) content. Also used as the maximum viewport when calculating fluid font sizes
		 */
		wideSize?: string;
		/**
		 * Disable the layout UI controls.
		 */
		allowEditing?: boolean;
		/**
		 * Enable or disable the custom content and wide size controls.
		 */
		allowCustomContentAndWideSize?: boolean;
	};
	[k: string]: unknown;
}
export interface SettingsLightboxProperties {
	/**
	 * Settings related to the lightbox.
	 */
	lightbox?: {
		/**
		 * Defines whether the lightbox is enabled or not.
		 */
		enabled?: boolean;
		/**
		 * Defines whether to show the Lightbox UI in the block editor. If set to `false`, the user won't be able to change the lightbox settings in the block editor.
		 */
		allowEditing?: boolean;
	};
	[k: string]: unknown;
}
export interface SettingsPositionProperties {
	/**
	 * Settings related to position.
	 */
	position?: {
		/**
		 * Allow users to set sticky position.
		 */
		sticky?: boolean;
	};
	[k: string]: unknown;
}
export interface SettingsShadowProperties {
	/**
	 * Settings related to shadows.
	 */
	shadow?: {
		/**
		 * Allow users to choose shadows from the default shadow presets.
		 */
		defaultPresets?: boolean;
		/**
		 * Shadow presets for the shadow picker.
		 * Generates a single custom property (`--wp--preset--shadow--{slug}`) per preset value.
		 */
		presets?: {
			/**
			 * Name of the shadow preset, translatable.
			 */
			name: string;
			/**
			 * Kebab-case unique identifier for the shadow preset.
			 */
			slug: string;
			/**
			 * CSS box-shadow value
			 */
			shadow: string;
		}[];
	};
	[k: string]: unknown;
}
export interface SettingsSpacingProperties {
	/**
	 * Settings related to spacing.
	 */
	spacing?: {
		/**
		 * Enables `--wp--style--block-gap` to be generated from styles.spacing.blockGap.
		 * A value of `null` instead of `false` further disables layout styles from being generated.
		 */
		blockGap?: boolean | null;
		/**
		 * Allow users to set a custom margin.
		 */
		margin?: boolean;
		/**
		 * Allow users to set a custom padding.
		 */
		padding?: boolean;
		/**
		 * List of units the user can use for spacing values.
		 *
		 * @minItems 1
		 */
		units?: [string, ...string[]];
		/**
		 * Allow users to set custom space sizes.
		 */
		customSpacingSize?: boolean;
		/**
		 * Allow users to choose space sizes from the default space size presets.
		 */
		defaultSpacingSizes?: boolean;
		/**
		 * Space size presets for the space size selector.
		 * Generates a custom property (`--wp--preset--spacing--{slug}`) per preset value.
		 */
		spacingSizes?: {
			/**
			 * Name of the space size preset, translatable.
			 */
			name?: string;
			/**
			 * Unique identifier for the space size preset. For best cross theme compatibility these should be in the form '10','20','30','40','50','60', etc. with '50' representing the 'Medium' size step. If all slugs begin with a number they will be merged with default and user slugs and sorted numerically.
			 */
			slug?: string;
			/**
			 * CSS space-size value, including units.
			 */
			size?: string;
		}[];
		/**
		 * Settings to auto-generate space size presets for the space size selector.
		 * Generates a custom property (--wp--preset--spacing--{slug}`) per preset value.
		 */
		spacingScale?: {
			/**
			 * With + or * depending on whether scale is generated by increment or multiplier.
			 */
			operator?: "+" | "*";
			/**
			 * The amount to increment each step by.
			 */
			increment?: number;
			/**
			 * Number of steps to generate in scale.
			 */
			steps?: number;
			/**
			 * The value to medium setting in the scale.
			 */
			mediumStep?: number;
			/**
			 * Unit that the scale uses, eg. rem, em, px.
			 */
			unit?:
				| "px"
				| "em"
				| "rem"
				| "%"
				| "vw"
				| "svw"
				| "lvw"
				| "dvw"
				| "vh"
				| "svh"
				| "lvh"
				| "dvh"
				| "vi"
				| "svi"
				| "lvi"
				| "dvi"
				| "vb"
				| "svb"
				| "lvb"
				| "dvb"
				| "vmin"
				| "svmin"
				| "lvmin"
				| "dvmin"
				| "vmax"
				| "svmax"
				| "lvmax"
				| "dvmax";
		};
	};
	[k: string]: unknown;
}
export interface SettingsTypographyProperties {
	/**
	 * Settings related to typography.
	 */
	typography?: {
		/**
		 * Allow users to choose font sizes from the default font size presets.
		 */
		defaultFontSizes?: boolean;
		/**
		 * Allow users to set custom font sizes.
		 */
		customFontSize?: boolean;
		/**
		 * Allow users to set custom font styles.
		 */
		fontStyle?: boolean;
		/**
		 * Allow users to set custom font weights.
		 */
		fontWeight?: boolean;
		/**
		 * Enables fluid typography and allows users to set global fluid typography parameters.
		 */
		fluid?:
			| {
					/**
					 * Allow users to set a global minimum font size boundary in px, rem or em. Custom font sizes below this value will not be clamped, and all calculated minimum font sizes will be, at a minimum, this value.
					 */
					minFontSize?: string;
					/**
					 * Allow users to set custom a max viewport width in px, rem or em, used to set the maximum size boundary of a fluid font size.
					 */
					maxViewportWidth?: string;
					/**
					 * Allow users to set a custom min viewport width in px, rem or em, used to set the minimum size boundary of a fluid font size.
					 */
					minViewportWidth?: string;
			  }
			| boolean;
		/**
		 * Allow users to set custom letter spacing.
		 */
		letterSpacing?: boolean;
		/**
		 * Allow users to set custom line height.
		 */
		lineHeight?: boolean;
		/**
		 * Allow users to set the text align.
		 */
		textAlign?: boolean;
		/**
		 * Allow users to set the number of text columns.
		 */
		textColumns?: boolean;
		/**
		 * Allow users to set custom text decorations.
		 */
		textDecoration?: boolean;
		/**
		 * Allow users to set the writing mode.
		 */
		writingMode?: boolean;
		/**
		 * Allow users to set custom text transforms.
		 */
		textTransform?: boolean;
		/**
		 * Enable drop cap.
		 */
		dropCap?: boolean;
		/**
		 * Font size presets for the font size selector.
		 * Generates a single class (`.has-{slug}-color`) and custom property (`--wp--preset--font-size--{slug}`) per preset value.
		 */
		fontSizes?: {
			/**
			 * Name of the font size preset, translatable.
			 */
			name?: string;
			/**
			 * Kebab-case unique identifier for the font size preset.
			 */
			slug?: string;
			/**
			 * CSS font-size value, including units.
			 */
			size?: string;
			/**
			 * Specifies the minimum and maximum font size value of a fluid font size. Set to `false` to bypass fluid calculations and use the static `size` value.
			 */
			fluid?:
				| {
						/**
						 * A min font size for fluid font size calculations in px, rem or em.
						 */
						min?: string;
						/**
						 * A max font size for fluid font size calculations in px, rem or em.
						 */
						max?: string;
				  }
				| boolean;
		}[];
		/**
		 * Font family presets for the font family selector.
		 * Generates a single custom property (`--wp--preset--font-family--{slug}`) per preset value.
		 */
		fontFamilies?: {
			/**
			 * Name of the font family preset, translatable.
			 */
			name?: string;
			/**
			 * Kebab-case unique identifier for the font family preset.
			 */
			slug?: string;
			/**
			 * CSS font-family value.
			 */
			fontFamily?: string;
			/**
			 * Array of font-face declarations.
			 */
			fontFace?: {
				/**
				 * CSS font-family value.
				 */
				fontFamily: string;
				/**
				 * CSS font-style value.
				 */
				fontStyle?: string;
				/**
				 * List of available font weights, separated by a space.
				 */
				fontWeight?: string | number;
				/**
				 * CSS font-display value.
				 */
				fontDisplay?: "auto" | "block" | "fallback" | "swap" | "optional";
				/**
				 * Paths or URLs to the font files.
				 */
				src: string | string[];
				/**
				 * CSS font-stretch value.
				 */
				fontStretch?: string;
				/**
				 * CSS ascent-override value.
				 */
				ascentOverride?: string;
				/**
				 * CSS descent-override value.
				 */
				descentOverride?: string;
				/**
				 * CSS font-variant value.
				 */
				fontVariant?: string;
				/**
				 * CSS font-feature-settings value.
				 */
				fontFeatureSettings?: string;
				/**
				 * CSS font-variation-settings value.
				 */
				fontVariationSettings?: string;
				/**
				 * CSS line-gap-override value.
				 */
				lineGapOverride?: string;
				/**
				 * CSS size-adjust value.
				 */
				sizeAdjust?: string;
				/**
				 * CSS unicode-range value.
				 */
				unicodeRange?: string;
			}[];
		}[];
	};
	[k: string]: unknown;
}
export interface SettingsCustomProperties {
	custom?: SettingsCustomAdditionalProperties;
	[k: string]: unknown;
}
/**
 * Generate custom CSS custom properties of the form `--wp--custom--{key}--{nested-key}: {value};`. `camelCased` keys are transformed to `kebab-case` as to follow the CSS property naming schema. Keys at different depth levels are separated by `--`, so keys should not include `--` in the name.
 */
export interface SettingsCustomAdditionalProperties {
	[k: string]: string | number | SettingsCustomAdditionalProperties;
}
/**
 * Settings defined on a per-block basis.
 */
export interface SettingsBlocksPropertiesComplete {
	"core/accordion"?: SettingsPropertiesComplete;
	"core/accordion-heading"?: SettingsPropertiesComplete;
	"core/accordion-item"?: SettingsPropertiesComplete;
	"core/accordion-panel"?: SettingsPropertiesComplete;
	"core/archives"?: SettingsPropertiesComplete;
	"core/audio"?: SettingsPropertiesComplete;
	"core/avatar"?: SettingsPropertiesComplete;
	"core/block"?: SettingsPropertiesComplete;
	"core/button"?: SettingsPropertiesComplete;
	"core/buttons"?: SettingsPropertiesComplete;
	"core/calendar"?: SettingsPropertiesComplete;
	"core/categories"?: SettingsPropertiesComplete;
	"core/code"?: SettingsPropertiesComplete;
	"core/column"?: SettingsPropertiesComplete;
	"core/columns"?: SettingsPropertiesComplete;
	"core/comment-author-avatar"?: SettingsPropertiesComplete;
	"core/comment-author-name"?: SettingsPropertiesComplete;
	"core/comment-content"?: SettingsPropertiesComplete;
	"core/comment-date"?: SettingsPropertiesComplete;
	"core/comment-edit-link"?: SettingsPropertiesComplete;
	"core/comment-reply-link"?: SettingsPropertiesComplete;
	"core/comments"?: SettingsPropertiesComplete;
	"core/comments-pagination"?: SettingsPropertiesComplete;
	"core/comments-pagination-next"?: SettingsPropertiesComplete;
	"core/comments-pagination-numbers"?: SettingsPropertiesComplete;
	"core/comments-pagination-previous"?: SettingsPropertiesComplete;
	"core/comments-title"?: SettingsPropertiesComplete;
	"core/comment-template"?: SettingsPropertiesComplete;
	"core/cover"?: SettingsPropertiesComplete;
	"core/details"?: SettingsPropertiesComplete;
	"core/embed"?: SettingsPropertiesComplete;
	"core/file"?: SettingsPropertiesComplete;
	"core/footnotes"?: SettingsPropertiesComplete;
	"core/freeform"?: SettingsPropertiesComplete;
	"core/gallery"?: SettingsPropertiesComplete;
	"core/group"?: SettingsPropertiesComplete;
	"core/heading"?: SettingsPropertiesComplete;
	"core/home-link"?: SettingsPropertiesComplete;
	"core/html"?: SettingsPropertiesComplete;
	"core/image"?: SettingsPropertiesComplete;
	"core/latest-comments"?: SettingsPropertiesComplete;
	"core/latest-posts"?: SettingsPropertiesComplete;
	"core/list"?: SettingsPropertiesComplete;
	"core/list-item"?: SettingsPropertiesComplete;
	"core/loginout"?: SettingsPropertiesComplete;
	"core/math"?: SettingsPropertiesComplete;
	"core/media-text"?: SettingsPropertiesComplete;
	"core/missing"?: SettingsPropertiesComplete;
	"core/more"?: SettingsPropertiesComplete;
	"core/navigation"?: SettingsPropertiesComplete;
	"core/navigation-link"?: SettingsPropertiesComplete;
	"core/navigation-submenu"?: SettingsPropertiesComplete;
	"core/nextpage"?: SettingsPropertiesComplete;
	"core/page-list"?: SettingsPropertiesComplete;
	"core/page-list-item"?: SettingsPropertiesComplete;
	"core/paragraph"?: SettingsPropertiesComplete;
	"core/post-author"?: SettingsPropertiesComplete;
	"core/post-author-biography"?: SettingsPropertiesComplete;
	"core/post-author-name"?: SettingsPropertiesComplete;
	"core/post-comment"?: SettingsPropertiesComplete;
	"core/post-comments-count"?: SettingsPropertiesComplete;
	"core/post-comments-form"?: SettingsPropertiesComplete;
	"core/post-comments-link"?: SettingsPropertiesComplete;
	"core/post-content"?: SettingsPropertiesComplete;
	"core/post-date"?: SettingsPropertiesComplete;
	"core/post-excerpt"?: SettingsPropertiesComplete;
	"core/post-featured-image"?: SettingsPropertiesComplete;
	"core/post-navigation-link"?: SettingsPropertiesComplete;
	"core/post-template"?: SettingsPropertiesComplete;
	"core/post-terms"?: SettingsPropertiesComplete;
	"core/post-time-to-read"?: SettingsPropertiesComplete;
	"core/post-title"?: SettingsPropertiesComplete;
	"core/preformatted"?: SettingsPropertiesComplete;
	"core/pullquote"?: SettingsPropertiesComplete;
	"core/query"?: SettingsPropertiesComplete;
	"core/query-no-results"?: SettingsPropertiesComplete;
	"core/query-pagination"?: SettingsPropertiesComplete;
	"core/query-pagination-next"?: SettingsPropertiesComplete;
	"core/query-pagination-numbers"?: SettingsPropertiesComplete;
	"core/query-pagination-previous"?: SettingsPropertiesComplete;
	"core/query-title"?: SettingsPropertiesComplete;
	"core/query-total"?: SettingsPropertiesComplete;
	"core/quote"?: SettingsPropertiesComplete;
	"core/read-more"?: SettingsPropertiesComplete;
	"core/rss"?: SettingsPropertiesComplete;
	"core/search"?: SettingsPropertiesComplete;
	"core/separator"?: SettingsPropertiesComplete;
	"core/shortcode"?: SettingsPropertiesComplete;
	"core/site-logo"?: SettingsPropertiesComplete;
	"core/site-tagline"?: SettingsPropertiesComplete;
	"core/site-title"?: SettingsPropertiesComplete;
	"core/social-link"?: SettingsPropertiesComplete;
	"core/social-links"?: SettingsPropertiesComplete;
	"core/spacer"?: SettingsPropertiesComplete;
	"core/table"?: SettingsPropertiesComplete;
	"core/tag-cloud"?: SettingsPropertiesComplete;
	"core/template-part"?: SettingsPropertiesComplete;
	"core/term-count"?: SettingsPropertiesComplete;
	"core/term-description"?: SettingsPropertiesComplete;
	"core/term-name"?: SettingsPropertiesComplete;
	"core/term-template"?: SettingsPropertiesComplete;
	"core/terms-query"?: SettingsPropertiesComplete;
	"core/text-columns"?: SettingsPropertiesComplete;
	"core/verse"?: SettingsPropertiesComplete;
	"core/video"?: SettingsPropertiesComplete;
	"core/widget-area"?: SettingsPropertiesComplete;
	"core/legacy-widget"?: SettingsPropertiesComplete;
	"core/widget-group"?: SettingsPropertiesComplete;
	[k: string]: SettingsPropertiesComplete;
}
export interface StylesProperties {
	/**
	 * Background styles.
	 */
	background?: {
		/**
		 * Sets the `background-image` CSS property.
		 */
		backgroundImage?:
			| string
			| RefComplete
			| {
					/**
					 * A URL to an image file, or a path to a file relative to the theme root directory, and prefixed with `file:`, e.g., 'file:./path/to/file.png'.
					 */
					url?: string;
			  };
		/**
		 * Sets the `background-position` CSS property.
		 */
		backgroundPosition?: string | RefComplete;
		/**
		 * Sets the `background-repeat` CSS property.
		 */
		backgroundRepeat?: string | RefComplete;
		/**
		 * Sets the `background-size` CSS property.
		 */
		backgroundSize?: string | RefComplete;
		/**
		 * Sets the `background-attachment` CSS property.
		 */
		backgroundAttachment?: string | RefComplete;
	};
	/**
	 * Border styles.
	 */
	border?: {
		/**
		 * Sets the `border-color` CSS property.
		 */
		color?: string | RefComplete;
		/**
		 * Sets the `border-radius` CSS property.
		 */
		radius?:
			| string
			| RefComplete
			| {
					/**
					 * Sets the `border-top-left-radius` CSS property.
					 */
					topLeft?: string | RefComplete;
					/**
					 * Sets the `border-top-right-radius` CSS property.
					 */
					topRight?: string | RefComplete;
					/**
					 * Sets the `border-bottom-left-radius` CSS property.
					 */
					bottomLeft?: string | RefComplete;
					/**
					 * Sets the `border-bottom-right-radius` CSS property.
					 */
					bottomRight?: string | RefComplete;
					[k: string]: unknown;
			  };
		/**
		 * Sets the `border-style` CSS property.
		 */
		style?: string | RefComplete;
		/**
		 * Sets the `border-width` CSS property.
		 */
		width?: string | RefComplete;
		top?: {
			/**
			 * Sets the `border-top-color` CSS property.
			 */
			color?: string | RefComplete;
			/**
			 * Sets the `border-top-style` CSS property.
			 */
			style?: string | RefComplete;
			/**
			 * Sets the `border-top-width` CSS property.
			 */
			width?: string | RefComplete;
		};
		right?: {
			/**
			 * Sets the `border-right-color` CSS property.
			 */
			color?: string | RefComplete;
			/**
			 * Sets the `border-right-style` CSS property.
			 */
			style?: string | RefComplete;
			/**
			 * Sets the `border-right-width` CSS property.
			 */
			width?: string | RefComplete;
		};
		bottom?: {
			/**
			 * Sets the `border-bottom-color` CSS property.
			 */
			color?: string | RefComplete;
			/**
			 * Sets the `border-bottom-style` CSS property.
			 */
			style?: string | RefComplete;
			/**
			 * Sets the `border-bottom-width` CSS property.
			 */
			width?: string | RefComplete;
		};
		left?: {
			/**
			 * Sets the `border-left-color` CSS property.
			 */
			color?: string | RefComplete;
			/**
			 * Sets the `border-left-style` CSS property.
			 */
			style?: string | RefComplete;
			/**
			 * Sets the `border-left-width` CSS property.
			 */
			width?: string | RefComplete;
		};
	};
	/**
	 * Color styles.
	 */
	color?: {
		/**
		 * Sets the `background-color` CSS property.
		 */
		background?: string | RefComplete;
		/**
		 * Sets the `background` CSS property.
		 */
		gradient?: string | RefComplete;
		/**
		 * Sets the `color` CSS property.
		 */
		text?: string | RefComplete;
	};
	/**
	 * Sets custom CSS to apply styling not covered by other theme.json properties.
	 */
	css?: string;
	/**
	 * Dimensions styles.
	 */
	dimensions?: {
		/**
		 * Sets the `aspect-ratio` CSS property.
		 */
		aspectRatio?: string | RefComplete;
		/**
		 * Sets the `min-height` CSS property.
		 */
		minHeight?: string | RefComplete;
		/**
		 * Sets the `width` CSS property.
		 */
		width?: string | RefComplete;
		[k: string]: unknown;
	};
	/**
	 * CSS and SVG filter styles.
	 */
	filter?: {
		/**
		 * Sets the duotone filter.
		 */
		duotone?: string | RefComplete;
	};
	/**
	 * Outline styles.
	 */
	outline?: {
		/**
		 * Sets the `outline-color` CSS property.
		 */
		color?: string | RefComplete;
		/**
		 * Sets the `outline-offset` CSS property.
		 */
		offset?: string | RefComplete;
		/**
		 * Sets the `outline-style` CSS property.
		 */
		style?: string | RefComplete;
		/**
		 * Sets the `outline-width` CSS property.
		 */
		width?: string | RefComplete;
	};
	/**
	 * Box shadow styles.
	 */
	shadow?: string | RefComplete;
	/**
	 * Spacing styles.
	 */
	spacing?: {
		/**
		 * Sets the `--wp--style--block-gap` CSS custom property when settings.spacing.blockGap is true.
		 */
		blockGap?: string | RefComplete;
		/**
		 * Margin styles.
		 */
		margin?: {
			/**
			 * Sets the `margin-top` CSS property.
			 */
			top?: string | RefComplete;
			/**
			 * Sets the `margin-right` CSS property.
			 */
			right?: string | RefComplete;
			/**
			 * Sets the `margin-bottom` CSS property.
			 */
			bottom?: string | RefComplete;
			/**
			 * Sets the `margin-left` CSS property.
			 */
			left?: string | RefComplete;
		};
		/**
		 * Padding styles.
		 */
		padding?: {
			/**
			 * Sets the `padding-top` CSS property.
			 */
			top?: string | RefComplete;
			/**
			 * Sets the `padding-right` CSS property.
			 */
			right?: string | RefComplete;
			/**
			 * Sets the `padding-bottom` CSS property.
			 */
			bottom?: string | RefComplete;
			/**
			 * Sets the `padding-left` CSS property.
			 */
			left?: string | RefComplete;
		};
	};
	/**
	 * Typography styles.
	 */
	typography?: {
		/**
		 * Sets the `font-family` CSS property.
		 */
		fontFamily?: string | RefComplete;
		/**
		 * Sets the `font-size` CSS property.
		 */
		fontSize?: string | RefComplete;
		/**
		 * Sets the `font-style` CSS property.
		 */
		fontStyle?: string | RefComplete;
		/**
		 * Sets the `font-weight` CSS property.
		 */
		fontWeight?: string | RefComplete;
		/**
		 * Sets the `letter-spacing` CSS property.
		 */
		letterSpacing?: string | RefComplete;
		/**
		 * Sets the `line-height` CSS property.
		 */
		lineHeight?: string | RefComplete;
		/**
		 * Sets the `text-align` CSS property.
		 */
		textAlign?: string | RefComplete;
		/**
		 * Sets the `column-count` CSS property.
		 */
		textColumns?: string | RefComplete;
		/**
		 * Sets the `text-decoration` CSS property.
		 */
		textDecoration?: string | RefComplete;
		/**
		 * Sets the `writing-mode` CSS property.
		 */
		writingMode?: string | RefComplete;
		/**
		 * Sets the `text-transform` CSS property.
		 */
		textTransform?: string | RefComplete;
	};
	[k: string]: unknown;
}
export interface RefComplete {
	/**
	 * A reference to another property value. e.g. `styles.color.text`
	 */
	ref?: string;
}
/**
 * Styles defined on a per-element basis using the element's selector.
 */
export interface StylesElementsPropertiesComplete {
	button?: StylesProperties &
		StylesElementsPseudoSelectorsProperties & {
			[k: string]: unknown;
		};
	link?: StylesProperties &
		StylesElementsPseudoSelectorsProperties & {
			[k: string]: unknown;
		};
	heading?: StylesPropertiesComplete;
	h1?: StylesPropertiesComplete;
	h2?: StylesPropertiesComplete;
	h3?: StylesPropertiesComplete;
	h4?: StylesPropertiesComplete;
	h5?: StylesPropertiesComplete;
	h6?: StylesPropertiesComplete;
	caption?: StylesPropertiesComplete;
	cite?: StylesPropertiesComplete;
	select?: StylesPropertiesComplete;
	textInput?: StylesPropertiesComplete;
}
export interface StylesElementsPseudoSelectorsProperties {
	":active"?: StylesPropertiesComplete;
	":any-link"?: StylesPropertiesComplete;
	":focus"?: StylesPropertiesComplete;
	":focus-visible"?: StylesPropertiesComplete;
	":hover"?: StylesPropertiesComplete;
	":link"?: StylesPropertiesComplete;
	":visited"?: StylesPropertiesComplete;
	[k: string]: unknown;
}
/**
 * Styles defined on a per-block basis using the block's selector.
 */
export interface StylesBlocksPropertiesComplete {
	"core/accordion"?: StylesPropertiesAndElementsComplete;
	"core/accordion-heading"?: StylesPropertiesAndElementsComplete;
	"core/accordion-item"?: StylesPropertiesAndElementsComplete;
	"core/accordion-panel"?: StylesPropertiesAndElementsComplete;
	"core/archives"?: StylesPropertiesAndElementsComplete;
	"core/audio"?: StylesPropertiesAndElementsComplete;
	"core/avatar"?: StylesPropertiesAndElementsComplete;
	"core/block"?: StylesPropertiesAndElementsComplete;
	"core/button"?: StylesPropertiesAndElementsComplete & StylesBlocksPseudoSelectorsProperties;
	"core/buttons"?: StylesPropertiesAndElementsComplete;
	"core/calendar"?: StylesPropertiesAndElementsComplete;
	"core/categories"?: StylesPropertiesAndElementsComplete;
	"core/code"?: StylesPropertiesAndElementsComplete;
	"core/column"?: StylesPropertiesAndElementsComplete;
	"core/columns"?: StylesPropertiesAndElementsComplete;
	"core/comment-author-avatar"?: StylesPropertiesAndElementsComplete;
	"core/comment-author-name"?: StylesPropertiesAndElementsComplete;
	"core/comment-content"?: StylesPropertiesAndElementsComplete;
	"core/comment-date"?: StylesPropertiesAndElementsComplete;
	"core/comment-edit-link"?: StylesPropertiesAndElementsComplete;
	"core/comment-reply-link"?: StylesPropertiesAndElementsComplete;
	"core/comments"?: StylesPropertiesAndElementsComplete;
	"core/comments-pagination"?: StylesPropertiesAndElementsComplete;
	"core/comments-pagination-next"?: StylesPropertiesAndElementsComplete;
	"core/comments-pagination-numbers"?: StylesPropertiesAndElementsComplete;
	"core/comments-pagination-previous"?: StylesPropertiesAndElementsComplete;
	"core/comments-title"?: StylesPropertiesAndElementsComplete;
	"core/comment-template"?: StylesPropertiesAndElementsComplete;
	"core/cover"?: StylesPropertiesAndElementsComplete;
	"core/details"?: StylesPropertiesAndElementsComplete;
	"core/embed"?: StylesPropertiesAndElementsComplete;
	"core/file"?: StylesPropertiesAndElementsComplete;
	"core/footnotes"?: StylesPropertiesAndElementsComplete;
	"core/freeform"?: StylesPropertiesAndElementsComplete;
	"core/gallery"?: StylesPropertiesAndElementsComplete;
	"core/group"?: StylesPropertiesAndElementsComplete;
	"core/heading"?: StylesPropertiesAndElementsComplete;
	"core/home-link"?: StylesPropertiesAndElementsComplete;
	"core/html"?: StylesPropertiesAndElementsComplete;
	"core/image"?: StylesPropertiesAndElementsComplete;
	"core/latest-comments"?: StylesPropertiesAndElementsComplete;
	"core/latest-posts"?: StylesPropertiesAndElementsComplete;
	"core/list"?: StylesPropertiesAndElementsComplete;
	"core/list-item"?: StylesPropertiesAndElementsComplete;
	"core/loginout"?: StylesPropertiesAndElementsComplete;
	"core/math"?: StylesPropertiesAndElementsComplete;
	"core/media-text"?: StylesPropertiesAndElementsComplete;
	"core/missing"?: StylesPropertiesAndElementsComplete;
	"core/more"?: StylesPropertiesAndElementsComplete;
	"core/navigation"?: StylesPropertiesAndElementsComplete;
	"core/navigation-link"?: StylesPropertiesAndElementsComplete;
	"core/navigation-submenu"?: StylesPropertiesAndElementsComplete;
	"core/nextpage"?: StylesPropertiesAndElementsComplete;
	"core/page-list"?: StylesPropertiesAndElementsComplete;
	"core/page-list-item"?: StylesPropertiesAndElementsComplete;
	"core/paragraph"?: StylesPropertiesAndElementsComplete;
	"core/post-author"?: StylesPropertiesAndElementsComplete;
	"core/post-author-biography"?: StylesPropertiesAndElementsComplete;
	"core/post-author-name"?: StylesPropertiesAndElementsComplete;
	"core/post-comment"?: StylesPropertiesAndElementsComplete;
	"core/post-comments-count"?: StylesPropertiesAndElementsComplete;
	"core/post-comments-form"?: StylesPropertiesAndElementsComplete;
	"core/post-comments-link"?: StylesPropertiesAndElementsComplete;
	"core/post-content"?: StylesPropertiesAndElementsComplete;
	"core/post-date"?: StylesPropertiesAndElementsComplete;
	"core/post-excerpt"?: StylesPropertiesAndElementsComplete;
	"core/post-featured-image"?: StylesPropertiesAndElementsComplete;
	"core/post-navigation-link"?: StylesPropertiesAndElementsComplete;
	"core/post-template"?: StylesPropertiesAndElementsComplete;
	"core/post-terms"?: StylesPropertiesAndElementsComplete;
	"core/post-time-to-read"?: StylesPropertiesAndElementsComplete;
	"core/post-title"?: StylesPropertiesAndElementsComplete;
	"core/preformatted"?: StylesPropertiesAndElementsComplete;
	"core/pullquote"?: StylesPropertiesAndElementsComplete;
	"core/query"?: StylesPropertiesAndElementsComplete;
	"core/query-no-results"?: StylesPropertiesAndElementsComplete;
	"core/query-pagination"?: StylesPropertiesAndElementsComplete;
	"core/query-pagination-next"?: StylesPropertiesAndElementsComplete;
	"core/query-pagination-numbers"?: StylesPropertiesAndElementsComplete;
	"core/query-pagination-previous"?: StylesPropertiesAndElementsComplete;
	"core/query-title"?: StylesPropertiesAndElementsComplete;
	"core/query-total"?: StylesPropertiesAndElementsComplete;
	"core/quote"?: StylesPropertiesAndElementsComplete;
	"core/read-more"?: StylesPropertiesAndElementsComplete;
	"core/rss"?: StylesPropertiesAndElementsComplete;
	"core/search"?: StylesPropertiesAndElementsComplete;
	"core/separator"?: StylesPropertiesAndElementsComplete;
	"core/shortcode"?: StylesPropertiesAndElementsComplete;
	"core/site-logo"?: StylesPropertiesAndElementsComplete;
	"core/site-tagline"?: StylesPropertiesAndElementsComplete;
	"core/site-title"?: StylesPropertiesAndElementsComplete;
	"core/social-link"?: StylesPropertiesAndElementsComplete;
	"core/social-links"?: StylesPropertiesAndElementsComplete;
	"core/spacer"?: StylesPropertiesAndElementsComplete;
	"core/table"?: StylesPropertiesAndElementsComplete;
	"core/tag-cloud"?: StylesPropertiesAndElementsComplete;
	"core/template-part"?: StylesPropertiesAndElementsComplete;
	"core/term-count"?: StylesPropertiesAndElementsComplete;
	"core/term-description"?: StylesPropertiesAndElementsComplete;
	"core/term-name"?: StylesPropertiesAndElementsComplete;
	"core/term-template"?: StylesPropertiesAndElementsComplete;
	"core/terms-query"?: StylesPropertiesAndElementsComplete;
	"core/text-columns"?: StylesPropertiesAndElementsComplete;
	"core/verse"?: StylesPropertiesAndElementsComplete;
	"core/video"?: StylesPropertiesAndElementsComplete;
	"core/widget-area"?: StylesPropertiesAndElementsComplete;
	"core/legacy-widget"?: StylesPropertiesAndElementsComplete;
	"core/widget-group"?: StylesPropertiesAndElementsComplete;
	[k: string]: StylesPropertiesAndElementsComplete;
}
export interface StylesVariationsPropertiesComplete {
	[k: string]: StylesVariationPropertiesComplete;
}
export interface StylesVariationBlocksPropertiesComplete {
	"core/accordion"?: StylesVariationBlockPropertiesComplete;
	"core/accordion-heading"?: StylesVariationBlockPropertiesComplete;
	"core/accordion-item"?: StylesVariationBlockPropertiesComplete;
	"core/accordion-panel"?: StylesVariationBlockPropertiesComplete;
	"core/archives"?: StylesVariationBlockPropertiesComplete;
	"core/audio"?: StylesVariationBlockPropertiesComplete;
	"core/avatar"?: StylesVariationBlockPropertiesComplete;
	"core/block"?: StylesVariationBlockPropertiesComplete;
	"core/button"?: StylesVariationBlockPropertiesComplete;
	"core/buttons"?: StylesVariationBlockPropertiesComplete;
	"core/calendar"?: StylesVariationBlockPropertiesComplete;
	"core/categories"?: StylesVariationBlockPropertiesComplete;
	"core/code"?: StylesVariationBlockPropertiesComplete;
	"core/column"?: StylesVariationBlockPropertiesComplete;
	"core/columns"?: StylesVariationBlockPropertiesComplete;
	"core/comment-author-avatar"?: StylesVariationBlockPropertiesComplete;
	"core/comment-author-name"?: StylesVariationBlockPropertiesComplete;
	"core/comment-content"?: StylesVariationBlockPropertiesComplete;
	"core/comment-date"?: StylesVariationBlockPropertiesComplete;
	"core/comment-edit-link"?: StylesVariationBlockPropertiesComplete;
	"core/comment-reply-link"?: StylesVariationBlockPropertiesComplete;
	"core/comments"?: StylesVariationBlockPropertiesComplete;
	"core/comments-pagination"?: StylesVariationBlockPropertiesComplete;
	"core/comments-pagination-next"?: StylesVariationBlockPropertiesComplete;
	"core/comments-pagination-numbers"?: StylesVariationBlockPropertiesComplete;
	"core/comments-pagination-previous"?: StylesVariationBlockPropertiesComplete;
	"core/comments-title"?: StylesVariationBlockPropertiesComplete;
	"core/comment-template"?: StylesVariationBlockPropertiesComplete;
	"core/cover"?: StylesVariationBlockPropertiesComplete;
	"core/details"?: StylesVariationBlockPropertiesComplete;
	"core/embed"?: StylesVariationBlockPropertiesComplete;
	"core/file"?: StylesVariationBlockPropertiesComplete;
	"core/footnotes"?: StylesVariationBlockPropertiesComplete;
	"core/freeform"?: StylesVariationBlockPropertiesComplete;
	"core/gallery"?: StylesVariationBlockPropertiesComplete;
	"core/group"?: StylesVariationBlockPropertiesComplete;
	"core/heading"?: StylesVariationBlockPropertiesComplete;
	"core/home-link"?: StylesVariationBlockPropertiesComplete;
	"core/html"?: StylesVariationBlockPropertiesComplete;
	"core/image"?: StylesVariationBlockPropertiesComplete;
	"core/latest-comments"?: StylesVariationBlockPropertiesComplete;
	"core/latest-posts"?: StylesVariationBlockPropertiesComplete;
	"core/list"?: StylesVariationBlockPropertiesComplete;
	"core/list-item"?: StylesVariationBlockPropertiesComplete;
	"core/loginout"?: StylesVariationBlockPropertiesComplete;
	"core/math"?: StylesVariationBlockPropertiesComplete;
	"core/media-text"?: StylesVariationBlockPropertiesComplete;
	"core/missing"?: StylesVariationBlockPropertiesComplete;
	"core/more"?: StylesVariationBlockPropertiesComplete;
	"core/navigation"?: StylesVariationBlockPropertiesComplete;
	"core/navigation-link"?: StylesVariationBlockPropertiesComplete;
	"core/navigation-submenu"?: StylesVariationBlockPropertiesComplete;
	"core/nextpage"?: StylesVariationBlockPropertiesComplete;
	"core/page-list"?: StylesVariationBlockPropertiesComplete;
	"core/page-list-item"?: StylesVariationBlockPropertiesComplete;
	"core/paragraph"?: StylesVariationBlockPropertiesComplete;
	"core/post-author"?: StylesVariationBlockPropertiesComplete;
	"core/post-author-biography"?: StylesVariationBlockPropertiesComplete;
	"core/post-author-name"?: StylesVariationBlockPropertiesComplete;
	"core/post-comment"?: StylesVariationBlockPropertiesComplete;
	"core/post-comments-count"?: StylesVariationBlockPropertiesComplete;
	"core/post-comments-form"?: StylesVariationBlockPropertiesComplete;
	"core/post-comments-link"?: StylesVariationBlockPropertiesComplete;
	"core/post-content"?: StylesVariationBlockPropertiesComplete;
	"core/post-date"?: StylesVariationBlockPropertiesComplete;
	"core/post-excerpt"?: StylesVariationBlockPropertiesComplete;
	"core/post-featured-image"?: StylesVariationBlockPropertiesComplete;
	"core/post-navigation-link"?: StylesVariationBlockPropertiesComplete;
	"core/post-template"?: StylesVariationBlockPropertiesComplete;
	"core/post-terms"?: StylesVariationBlockPropertiesComplete;
	"core/post-time-to-read"?: StylesVariationBlockPropertiesComplete;
	"core/post-title"?: StylesVariationBlockPropertiesComplete;
	"core/preformatted"?: StylesVariationBlockPropertiesComplete;
	"core/pullquote"?: StylesVariationBlockPropertiesComplete;
	"core/query"?: StylesVariationBlockPropertiesComplete;
	"core/query-no-results"?: StylesVariationBlockPropertiesComplete;
	"core/query-pagination"?: StylesVariationBlockPropertiesComplete;
	"core/query-pagination-next"?: StylesVariationBlockPropertiesComplete;
	"core/query-pagination-numbers"?: StylesVariationBlockPropertiesComplete;
	"core/query-pagination-previous"?: StylesVariationBlockPropertiesComplete;
	"core/query-title"?: StylesVariationBlockPropertiesComplete;
	"core/query-total"?: StylesPropertiesAndElementsComplete;
	"core/quote"?: StylesVariationBlockPropertiesComplete;
	"core/read-more"?: StylesVariationBlockPropertiesComplete;
	"core/rss"?: StylesVariationBlockPropertiesComplete;
	"core/search"?: StylesVariationBlockPropertiesComplete;
	"core/separator"?: StylesVariationBlockPropertiesComplete;
	"core/shortcode"?: StylesVariationBlockPropertiesComplete;
	"core/site-logo"?: StylesVariationBlockPropertiesComplete;
	"core/site-tagline"?: StylesVariationBlockPropertiesComplete;
	"core/site-title"?: StylesVariationBlockPropertiesComplete;
	"core/social-link"?: StylesVariationBlockPropertiesComplete;
	"core/social-links"?: StylesVariationBlockPropertiesComplete;
	"core/spacer"?: StylesVariationBlockPropertiesComplete;
	"core/table"?: StylesVariationBlockPropertiesComplete;
	"core/tag-cloud"?: StylesVariationBlockPropertiesComplete;
	"core/template-part"?: StylesVariationBlockPropertiesComplete;
	"core/term-count"?: StylesVariationBlockPropertiesComplete;
	"core/term-description"?: StylesVariationBlockPropertiesComplete;
	"core/term-name"?: StylesVariationBlockPropertiesComplete;
	"core/term-template"?: StylesVariationBlockPropertiesComplete;
	"core/terms-query"?: StylesVariationBlockPropertiesComplete;
	"core/text-columns"?: StylesVariationBlockPropertiesComplete;
	"core/verse"?: StylesVariationBlockPropertiesComplete;
	"core/video"?: StylesVariationBlockPropertiesComplete;
	"core/widget-area"?: StylesVariationBlockPropertiesComplete;
	"core/legacy-widget"?: StylesVariationBlockPropertiesComplete;
	"core/widget-group"?: StylesVariationBlockPropertiesComplete;
	[k: string]: StylesVariationBlockPropertiesComplete;
}
export interface StylesBlocksPseudoSelectorsProperties {
	":hover"?: StylesPropertiesComplete;
	":focus"?: StylesPropertiesComplete;
	":focus-visible"?: StylesPropertiesComplete;
	":active"?: StylesPropertiesComplete;
	[k: string]: unknown;
}
export interface StylesVariationsProperties {
	[k: string]: StylesVariationProperties;
}


/**
 * Shorter alias for the main theme.json type
 */
export type ThemeJson = JSONSchemaForWordPressBlockThemeGlobalSettingsAndStyles;
