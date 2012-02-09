<?php
/**
 * Various CSS Data for CSSTidy
 *
 * This file is part of CSSTidy.
 *
 * CSSTidy is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CSSTidy is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CSSTidy; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package csstidy
 * @author Florian Schmitz (floele at gmail dot com) 2005
 * @author Nikolay Matsievsky (speed at webo dot name) 2010
 */

define('AT_START',    1);
define('AT_END',      2);
define('SEL_START',   3);
define('SEL_END',     4);
define('PROPERTY',    5);
define('VALUE',       6);
define('COMMENT',     7);
define('DEFAULT_AT', 41);

/**
 * All whitespace allowed in CSS
 *
 * @version 1.0
 */
$csstidy_config = array();
$csstidy_config['whitespace'] = array(' ',"\n","\t","\r","\x0B");

/**
 * All CSS tokens used by csstidy
 *
 * @version 1.0
 */
$csstidy_config['tokens'] = '/@}{;:=\'"(,\\!$%&)*+.<>?[]^`|~';

/**
 * All CSS units (CSS 3 units included)
 *
 * @see compress_numbers()
 * @version 1.0.1
 */
$csstidy_config['units'] = array('in','cm','mm','pt','pc','px','rem','em','%','ex','ch','vw','vh','vm','deg','grad','rad','turn','ms','s','khz','hz','fr','gr');

/**
 * Available at-rules
 *
 * @version 1.0
 */
$csstidy_config['at_rules'] = array(
	'page' => 'is',
	'font-face' => 'is',
	'charset' => 'iv',
	'import' => 'iv',
	'namespace' => 'iv',
	'media' => 'at',
	'keyframes' => 'at' // ORLY?
);

 /**
 * Properties that need a value with unit
 *
 * @todo CSS3.0 properties
 * @see compress_numbers();
 * @version 1.2
 */
$csstidy_config['unit_values'] = array (
	'background',
	'background-position', 
	'border', 
	'border-top', 
	'border-right', 
	'border-bottom', 
	'border-left', 
	'border-width',
	'border-top-width', 
	'border-right-width', 
	'border-left-width',
	'border-bottom-width',
	'bottom',
	'border-spacing',
	'font-size', 
	'height', 
	'left', 
	'margin', 
	'margin-top', 
	'margin-right', 
	'margin-bottom', 
	'margin-left', 
	'max-height',
	'max-width', 
	'min-height', 
	'min-width', 
	'outline', 
	'outline-width', 
	'padding', 
	'padding-top', 
	'padding-right', 
	'padding-bottom', 
	'padding-left', 
	'right', 
	'top', 
	'text-indent', 
	'letter-spacing', 
	'word-spacing', 
	'width'
	);

/**
 * Properties that allow <color> as value
 *
 * @todo CSS3.0 properties
 * @see compress_numbers();
 * @version 1.0
 */
$csstidy_config['color_values'] = array();
$csstidy_config['color_values'][] = 'background-color';
$csstidy_config['color_values'][] = 'border-color';
$csstidy_config['color_values'][] = 'border-top-color';
$csstidy_config['color_values'][] = 'border-right-color';
$csstidy_config['color_values'][] = 'border-bottom-color';
$csstidy_config['color_values'][] = 'border-left-color';
$csstidy_config['color_values'][] = 'color';
$csstidy_config['color_values'][] = 'outline-color';

/**
 * Default values for the background properties
 *
 * @todo Possibly property names will change during CSS3.0 development
 * @see dissolve_short_bg()
 * @see merge_bg()
 * @version 1.0
 */
$csstidy_config['background_prop_default'] = array();
$csstidy_config['background_prop_default']['background-image'] = 'none';
$csstidy_config['background_prop_default']['background-size'] = 'auto';
$csstidy_config['background_prop_default']['background-repeat'] = 'repeat';
$csstidy_config['background_prop_default']['background-position'] = '0 0';
$csstidy_config['background_prop_default']['background-attachment'] = 'scroll';
$csstidy_config['background_prop_default']['background-clip'] = 'border';
$csstidy_config['background_prop_default']['background-origin'] = 'padding';
$csstidy_config['background_prop_default']['background-color'] = 'transparent';

/**
 * Default values for the font properties
 *
 * @see merge_fonts()
 * @version 1.3
 */
$csstidy_config['font_prop_default'] = array();
$csstidy_config['font_prop_default']['font-style'] = 'normal';
$csstidy_config['font_prop_default']['font-variant'] = 'normal';
$csstidy_config['font_prop_default']['font-weight'] = 'normal';
$csstidy_config['font_prop_default']['font-size'] = '';
$csstidy_config['font_prop_default']['line-height'] = '';
$csstidy_config['font_prop_default']['font-family'] = '';

/**
 * A list of non-W3C color names which get replaced by their hex-codes
 *
 * @global array $csstidy_config['replace_colors']
 * @see cut_color()
 * @version 1.0
 */
$csstidy_config['replace_colors'] = array();
$csstidy_config['replace_colors']['aliceblue'] = '#f0f8ff';
$csstidy_config['replace_colors']['antiquewhite'] = '#faebd7';
$csstidy_config['replace_colors']['aquamarine'] = '#7fffd4';
$csstidy_config['replace_colors']['azure'] = '#f0ffff';
$csstidy_config['replace_colors']['beige'] = '#f5f5dc';
$csstidy_config['replace_colors']['bisque'] = '#ffe4c4';
$csstidy_config['replace_colors']['blanchedalmond'] = '#ffebcd';
$csstidy_config['replace_colors']['blueviolet'] = '#8a2be2';
$csstidy_config['replace_colors']['brown'] = '#a52a2a';
$csstidy_config['replace_colors']['burlywood'] = '#deb887';
$csstidy_config['replace_colors']['cadetblue'] = '#5f9ea0';
$csstidy_config['replace_colors']['chartreuse'] = '#7fff00';
$csstidy_config['replace_colors']['chocolate'] = '#d2691e';
$csstidy_config['replace_colors']['coral'] = '#ff7f50';
$csstidy_config['replace_colors']['cornflowerblue'] = '#6495ed';
$csstidy_config['replace_colors']['cornsilk'] = '#fff8dc';
$csstidy_config['replace_colors']['crimson'] = '#dc143c';
$csstidy_config['replace_colors']['cyan'] = '#00ffff';
$csstidy_config['replace_colors']['darkblue'] = '#00008b';
$csstidy_config['replace_colors']['darkcyan'] = '#008b8b';
$csstidy_config['replace_colors']['darkgoldenrod'] = '#b8860b';
$csstidy_config['replace_colors']['darkgray'] = '#a9a9a9';
$csstidy_config['replace_colors']['darkgreen'] = '#006400';
$csstidy_config['replace_colors']['darkkhaki'] = '#bdb76b';
$csstidy_config['replace_colors']['darkmagenta'] = '#8b008b';
$csstidy_config['replace_colors']['darkolivegreen'] = '#556b2f';
$csstidy_config['replace_colors']['darkorange'] = '#ff8c00';
$csstidy_config['replace_colors']['darkorchid'] = '#9932cc';
$csstidy_config['replace_colors']['darkred'] = '#8b0000';
$csstidy_config['replace_colors']['darksalmon'] = '#e9967a';
$csstidy_config['replace_colors']['darkseagreen'] = '#8fbc8f';
$csstidy_config['replace_colors']['darkslateblue'] = '#483d8b';
$csstidy_config['replace_colors']['darkslategray'] = '#2f4f4f';
$csstidy_config['replace_colors']['darkturquoise'] = '#00ced1';
$csstidy_config['replace_colors']['darkviolet'] = '#9400d3';
$csstidy_config['replace_colors']['deeppink'] = '#ff1493';
$csstidy_config['replace_colors']['deepskyblue'] = '#00bfff';
$csstidy_config['replace_colors']['dimgray'] = '#696969';
$csstidy_config['replace_colors']['dodgerblue'] = '#1e90ff';
$csstidy_config['replace_colors']['feldspar'] = '#d19275';
$csstidy_config['replace_colors']['firebrick'] = '#b22222';
$csstidy_config['replace_colors']['floralwhite'] = '#fffaf0';
$csstidy_config['replace_colors']['forestgreen'] = '#228b22';
$csstidy_config['replace_colors']['gainsboro'] = '#dcdcdc';
$csstidy_config['replace_colors']['ghostwhite'] = '#f8f8ff';
$csstidy_config['replace_colors']['gold'] = '#ffd700';
$csstidy_config['replace_colors']['goldenrod'] = '#daa520';
$csstidy_config['replace_colors']['greenyellow'] = '#adff2f';
$csstidy_config['replace_colors']['honeydew'] = '#f0fff0';
$csstidy_config['replace_colors']['hotpink'] = '#ff69b4';
$csstidy_config['replace_colors']['indianred'] = '#cd5c5c';
$csstidy_config['replace_colors']['indigo'] = '#4b0082';
$csstidy_config['replace_colors']['ivory'] = '#fffff0';
$csstidy_config['replace_colors']['khaki'] = '#f0e68c';
$csstidy_config['replace_colors']['lavender'] = '#e6e6fa';
$csstidy_config['replace_colors']['lavenderblush'] = '#fff0f5';
$csstidy_config['replace_colors']['lawngreen'] = '#7cfc00';
$csstidy_config['replace_colors']['lemonchiffon'] = '#fffacd';
$csstidy_config['replace_colors']['lightblue'] = '#add8e6';
$csstidy_config['replace_colors']['lightcoral'] = '#f08080';
$csstidy_config['replace_colors']['lightcyan'] = '#e0ffff';
$csstidy_config['replace_colors']['lightgoldenrodyellow'] = '#fafad2';
$csstidy_config['replace_colors']['lightgrey'] = '#d3d3d3';
$csstidy_config['replace_colors']['lightgreen'] = '#90ee90';
$csstidy_config['replace_colors']['lightpink'] = '#ffb6c1';
$csstidy_config['replace_colors']['lightsalmon'] = '#ffa07a';
$csstidy_config['replace_colors']['lightseagreen'] = '#20b2aa';
$csstidy_config['replace_colors']['lightskyblue'] = '#87cefa';
$csstidy_config['replace_colors']['lightslateblue'] = '#8470ff';
$csstidy_config['replace_colors']['lightslategray'] = '#778899';
$csstidy_config['replace_colors']['lightsteelblue'] = '#b0c4de';
$csstidy_config['replace_colors']['lightyellow'] = '#ffffe0';
$csstidy_config['replace_colors']['limegreen'] = '#32cd32';
$csstidy_config['replace_colors']['linen'] = '#faf0e6';
$csstidy_config['replace_colors']['magenta'] = '#ff00ff';
$csstidy_config['replace_colors']['mediumaquamarine'] = '#66cdaa';
$csstidy_config['replace_colors']['mediumblue'] = '#0000cd';
$csstidy_config['replace_colors']['mediumorchid'] = '#ba55d3';
$csstidy_config['replace_colors']['mediumpurple'] = '#9370d8';
$csstidy_config['replace_colors']['mediumseagreen'] = '#3cb371';
$csstidy_config['replace_colors']['mediumslateblue'] = '#7b68ee';
$csstidy_config['replace_colors']['mediumspringgreen'] = '#00fa9a';
$csstidy_config['replace_colors']['mediumturquoise'] = '#48d1cc';
$csstidy_config['replace_colors']['mediumvioletred'] = '#c71585';
$csstidy_config['replace_colors']['midnightblue'] = '#191970';
$csstidy_config['replace_colors']['mintcream'] = '#f5fffa';
$csstidy_config['replace_colors']['mistyrose'] = '#ffe4e1';
$csstidy_config['replace_colors']['moccasin'] = '#ffe4b5';
$csstidy_config['replace_colors']['navajowhite'] = '#ffdead';
$csstidy_config['replace_colors']['oldlace'] = '#fdf5e6';
$csstidy_config['replace_colors']['olivedrab'] = '#6b8e23';
$csstidy_config['replace_colors']['orangered'] = '#ff4500';
$csstidy_config['replace_colors']['orchid'] = '#da70d6';
$csstidy_config['replace_colors']['palegoldenrod'] = '#eee8aa';
$csstidy_config['replace_colors']['palegreen'] = '#98fb98';
$csstidy_config['replace_colors']['paleturquoise'] = '#afeeee';
$csstidy_config['replace_colors']['palevioletred'] = '#d87093';
$csstidy_config['replace_colors']['papayawhip'] = '#ffefd5';
$csstidy_config['replace_colors']['peachpuff'] = '#ffdab9';
$csstidy_config['replace_colors']['peru'] = '#cd853f';
$csstidy_config['replace_colors']['pink'] = '#ffc0cb';
$csstidy_config['replace_colors']['plum'] = '#dda0dd';
$csstidy_config['replace_colors']['powderblue'] = '#b0e0e6';
$csstidy_config['replace_colors']['rosybrown'] = '#bc8f8f';
$csstidy_config['replace_colors']['royalblue'] = '#4169e1';
$csstidy_config['replace_colors']['saddlebrown'] = '#8b4513';
$csstidy_config['replace_colors']['salmon'] = '#fa8072';
$csstidy_config['replace_colors']['sandybrown'] = '#f4a460';
$csstidy_config['replace_colors']['seagreen'] = '#2e8b57';
$csstidy_config['replace_colors']['seashell'] = '#fff5ee';
$csstidy_config['replace_colors']['sienna'] = '#a0522d';
$csstidy_config['replace_colors']['skyblue'] = '#87ceeb';
$csstidy_config['replace_colors']['slateblue'] = '#6a5acd';
$csstidy_config['replace_colors']['slategray'] = '#708090';
$csstidy_config['replace_colors']['snow'] = '#fffafa';
$csstidy_config['replace_colors']['springgreen'] = '#00ff7f';
$csstidy_config['replace_colors']['steelblue'] = '#4682b4';
$csstidy_config['replace_colors']['tan'] = '#d2b48c';
$csstidy_config['replace_colors']['thistle'] = '#d8bfd8';
$csstidy_config['replace_colors']['tomato'] = '#ff6347';
$csstidy_config['replace_colors']['turquoise'] = '#40e0d0';
$csstidy_config['replace_colors']['violet'] = '#ee82ee';
$csstidy_config['replace_colors']['violetred'] = '#d02090';
$csstidy_config['replace_colors']['wheat'] = '#f5deb3';
$csstidy_config['replace_colors']['whitesmoke'] = '#f5f5f5';
$csstidy_config['replace_colors']['yellowgreen'] = '#9acd32';

/**
 * A list of all shorthand properties that are devided into four properties and/or have four subvalues
 *
 * @todo Are there new ones in CSS3.0?
 * @see dissolve_4value_shorthands()
 * @see merge_4value_shorthands()
 * @version 1.1
 */
$csstidy_config['shorthands'] = array();
$csstidy_config['shorthands']['border-color'] = array(
	'border-top-color',
	'border-right-color',
	'border-bottom-color',
	'border-left-color'
	);
$csstidy_config['shorthands']['border-style'] = array(
	'border-top-style',
	'border-right-style',
	'border-bottom-style',
	'border-left-style'
	);
$csstidy_config['shorthands']['border-width'] = array(
	'border-top-width',
	'border-right-width',
	'border-bottom-width',
	'border-left-width'
	);
$csstidy_config['shorthands']['margin'] = array(
	'margin-top',
	'margin-right',
	'margin-bottom',
	'margin-left'
	);
$csstidy_config['shorthands']['padding'] = array(
	'padding-top',
	'padding-right',
	'padding-bottom',
	'padding-left'
	);
$csstidy_config['shorthands']['border-radius'] = array(
	'border-top-left-radius',
	'border-top-right-radius',
	'border-bottom-right-radius',
	'border-bottom-left-radius'
	);

/**
 * All CSS Properties. Needed for csstidy::property_is_next()
 *
 * @todo Add CSS3.0 properties
 * @version 1.1
 * @see csstidy::property_is_next()
 */
$csstidy_config['all_properties'] = array();
$csstidy_config['all_properties']['background'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['background-color'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['background-image'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['background-repeat'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['background-attachment'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['background-position'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-top'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-right'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-bottom'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-left'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-color'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-top-color'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-bottom-color'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-left-color'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-right-color'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-style'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-top-style'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-right-style'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-left-style'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-bottom-style'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-width'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-top-width'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-right-width'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-left-width'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-bottom-width'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-collapse'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['border-spacing'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['bottom'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['caption-side'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['content'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['clear'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['clip'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['color'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['counter-reset'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['counter-increment'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['cursor'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['empty-cells'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['display'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['direction'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['float'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['font'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['font-family'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['font-style'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['font-variant'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['font-weight'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['font-stretch'] = 'CSS2.0,CSS3.0';
$csstidy_config['all_properties']['font-size-adjust'] = 'CSS2.0,CSS3.0';
$csstidy_config['all_properties']['font-size'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['height'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['left'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['line-height'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['list-style'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['list-style-type'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['list-style-image'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['list-style-position'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['margin'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['margin-top'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['margin-right'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['margin-bottom'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['margin-left'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['marks'] = 'CSS1.0,CSS2.0,CSS3.0';
$csstidy_config['all_properties']['marker-offset'] = 'CSS2.0,CSS3.0';
$csstidy_config['all_properties']['max-height'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['max-width'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['min-height'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['min-width'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['overflow'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['orphans'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['outline'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['outline-width'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['outline-style'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['outline-color'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['padding'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['padding-top'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['padding-right'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['padding-bottom'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['padding-left'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['page-break-before'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['page-break-after'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['page-break-inside'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['page'] = 'CSS2.0';
$csstidy_config['all_properties']['position'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['quotes'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['resize'] = 'CSS3.0';
$csstidy_config['all_properties']['right'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['size'] = 'CSS1.0,CSS2.0,CSS3.0';
$csstidy_config['all_properties']['speak-header'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['table-layout'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['top'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['text-indent'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['text-align'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['text-decoration'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['text-shadow'] = 'CSS2.0,CSS3.0';
$csstidy_config['all_properties']['letter-spacing'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['word-spacing'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['text-transform'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['white-space'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['unicode-bidi'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['vertical-align'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['visibility'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['width'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['widows'] = 'CSS2.0,CSS2.1,CSS3.0';
$csstidy_config['all_properties']['z-index'] = 'CSS1.0,CSS2.0,CSS2.1,CSS3.0';
//CSS3
$csstidy_config['all_properties']['animation'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-delay'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-direction'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-duration'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-fill-mode'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-iteration-count'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-name'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-play-state'] = 'CSS3.0';
$csstidy_config['all_properties']['animation-timing-function'] = 'CSS3.0';

$csstidy_config['all_properties']['ime-mode'] = 'CSS3.0';

$csstidy_config['all_properties']['opacity'] = 'CSS3.0';

$csstidy_config['all_properties']['perspective'] = 'CSS3.0';
$csstidy_config['all_properties']['perspective-origin'] = 'CSS3.0';
$csstidy_config['all_properties']['pointer-events'] = 'CSS4.0'; // ?
$csstidy_config['all_properties']['text-align-last'] = 'CSS3.0';
$csstidy_config['all_properties']['text-decoration-color'] = 'CSS3.0';
$csstidy_config['all_properties']['text-decoration-line'] = 'CSS3.0';
$csstidy_config['all_properties']['text-decoration-style'] = 'CSS3.0';
$csstidy_config['all_properties']['transform'] = 'CSS3.0';
$csstidy_config['all_properties']['transform-origin'] = 'CSS3.0';
$csstidy_config['all_properties']['transform-style'] = 'CSS3.0';
$csstidy_config['all_properties']['transition'] = 'CSS3.0';
$csstidy_config['all_properties']['transition-delay'] = 'CSS3.0';
$csstidy_config['all_properties']['transition-duration'] = 'CSS3.0';
$csstidy_config['all_properties']['transition-property'] = 'CSS3.0';
$csstidy_config['all_properties']['transition-timing-function'] = 'CSS3.0';

$csstidy_config['all_properties']['border-radius'] = 'CSS3.0';
$csstidy_config['all_properties']['border-top-left-radius'] = 'CSS3.0';
$csstidy_config['all_properties']['border-top-right-radius'] = 'CSS3.0';
$csstidy_config['all_properties']['border-bottom-right-radius'] = 'CSS3.0';
$csstidy_config['all_properties']['border-bottom-left-radius'] = 'CSS3.0';
$csstidy_config['all_properties']['box-shadow'] = 'CSS3.0';
$csstidy_config['all_properties']['background-size'] = 'CSS3.0';
$csstidy_config['all_properties']['background-clip'] = 'CSS3.0';
$csstidy_config['all_properties']['background-origin'] = 'CSS3.0';
$csstidy_config['all_properties']['tab-size'] = 'CSS3.0';

/* Speech */
/* TODO: CSS3 */
$csstidy_config['all_properties']['volume'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['speak'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['pause'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['pause-before'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['pause-after'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['cue'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['cue-before'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['cue-after'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['play-during'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['azimuth'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['elevation'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['speech-rate'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['voice-family'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['pitch'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['pitch-range'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['stress'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['richness'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['speak-punctuation'] = 'CSS2.0,CSS2.1';
$csstidy_config['all_properties']['speak-numeral'] = 'CSS2.0,CSS2.1';

/**
 * An array containing all predefined templates.
 *
 * @version 1.0
 * @see csstidy::load_template()
 */
$csstidy_config['predefined_templates']['default'][] = '<span class="at">'; //string before @rule
$csstidy_config['predefined_templates']['default'][] = '</span> <span class="format">{</span>'."\n"; //bracket after @-rule
$csstidy_config['predefined_templates']['default'][] = '<span class="selector">'; //string before selector
$csstidy_config['predefined_templates']['default'][] = '</span> <span class="format">{</span>'."\n"; //bracket after selector
$csstidy_config['predefined_templates']['default'][] = '<span class="property">'; //string before property
$csstidy_config['predefined_templates']['default'][] = '</span><span class="value">'; //string after property+before value
$csstidy_config['predefined_templates']['default'][] = '</span><span class="format">;</span>'."\n"; //string after value
$csstidy_config['predefined_templates']['default'][] = '<span class="format">}</span>'; //closing bracket - selector
$csstidy_config['predefined_templates']['default'][] = "\n\n"; //space between blocks {...}
$csstidy_config['predefined_templates']['default'][] = "\n".'<span class="format">}</span>'. "\n\n"; //closing bracket @-rule
$csstidy_config['predefined_templates']['default'][] = ''; //indent in @-rule
$csstidy_config['predefined_templates']['default'][] = '<span class="comment">'; // before comment
$csstidy_config['predefined_templates']['default'][] = '</span>'."\n"; // after comment
$csstidy_config['predefined_templates']['default'][] = "\n"; // after last line @-rule

$csstidy_config['predefined_templates']['high_compression'][] = '<span class="at">';
$csstidy_config['predefined_templates']['high_compression'][] = '</span> <span class="format">{</span>'."\n";
$csstidy_config['predefined_templates']['high_compression'][] = '<span class="selector">';
$csstidy_config['predefined_templates']['high_compression'][] = '</span><span class="format">{</span>';
$csstidy_config['predefined_templates']['high_compression'][] = '<span class="property">';
$csstidy_config['predefined_templates']['high_compression'][] = '</span><span class="value">';
$csstidy_config['predefined_templates']['high_compression'][] = '</span><span class="format">;</span>';
$csstidy_config['predefined_templates']['high_compression'][] = '<span class="format">}</span>';
$csstidy_config['predefined_templates']['high_compression'][] = "\n";
$csstidy_config['predefined_templates']['high_compression'][] = "\n". '<span class="format">}'."\n".'</span>';
$csstidy_config['predefined_templates']['high_compression'][] = '';
$csstidy_config['predefined_templates']['high_compression'][] = '<span class="comment">'; // before comment
$csstidy_config['predefined_templates']['high_compression'][] = '</span>'; // after comment
$csstidy_config['predefined_templates']['high_compression'][] = "\n";

$csstidy_config['predefined_templates']['highest_compression'][] = '<span class="at">';
$csstidy_config['predefined_templates']['highest_compression'][] = '</span><span class="format">{</span>';
$csstidy_config['predefined_templates']['highest_compression'][] = '<span class="selector">';
$csstidy_config['predefined_templates']['highest_compression'][] = '</span><span class="format">{</span>';
$csstidy_config['predefined_templates']['highest_compression'][] = '<span class="property">';
$csstidy_config['predefined_templates']['highest_compression'][] = '</span><span class="value">';
$csstidy_config['predefined_templates']['highest_compression'][] = '</span><span class="format">;</span>';
$csstidy_config['predefined_templates']['highest_compression'][] = '<span class="format">}</span>';
$csstidy_config['predefined_templates']['highest_compression'][] = '';
$csstidy_config['predefined_templates']['highest_compression'][] = '<span class="format">}</span>';
$csstidy_config['predefined_templates']['highest_compression'][] = '';
$csstidy_config['predefined_templates']['highest_compression'][] = '<span class="comment">'; // before comment
$csstidy_config['predefined_templates']['highest_compression'][] = '</span>'; // after comment
$csstidy_config['predefined_templates']['highest_compression'][] = '';

$csstidy_config['predefined_templates']['no_compression'][] = '';
$csstidy_config['predefined_templates']['no_compression'][] = ' {'."\n";
$csstidy_config['predefined_templates']['no_compression'][] = '';
$csstidy_config['predefined_templates']['no_compression'][] = "\n".'{'."\n";
$csstidy_config['predefined_templates']['no_compression'][] = "\t";
$csstidy_config['predefined_templates']['no_compression'][] = '';
$csstidy_config['predefined_templates']['no_compression'][] = ';'."\n";
$csstidy_config['predefined_templates']['no_compression'][] = '}';
$csstidy_config['predefined_templates']['no_compression'][] = "\n\n";
$csstidy_config['predefined_templates']['no_compression'][] = "\n".'}'."\n\n";
$csstidy_config['predefined_templates']['no_compression'][] = "\t"; // @media and another
$csstidy_config['predefined_templates']['no_compression'][] = ''; // before comment
$csstidy_config['predefined_templates']['no_compression'][] = ''."\n"; // after comment
$csstidy_config['predefined_templates']['no_compression'][] = "\n";

/**
 * Need prefix values
 * version 1.0
 * @see csstidy::need_prefix()
 * @todo MOAR!!!
 */

$csstidy_config['need_vendor_prefixes']['border-radius'] = array ('-moz-border-radius', '-webkit-border-radius');
$csstidy_config['need_vendor_prefixes']['border-top-left-radius'] = array ('-moz-border-radius-topleft', '-webkit-border-top-left-radius');
$csstidy_config['need_vendor_prefixes']['border-top-right-radius'] = array ('-moz-border-radius-topright', '-webkit-border-top-right-radius');
$csstidy_config['need_vendor_prefixes']['border-bottom-right-radius'] = array ('-moz-border-radius-bottomright', '-webkit-border-bottom-right-radius');
$csstidy_config['need_vendor_prefixes']['border-bottom-left-radius'] = array ('-moz-border-radius-bottomleft', '-webkit-border-bottom-left-radius');

$csstidy_config['need_vendor_prefixes']['box-shadow'] = array ('-moz-box-shadow', '-webkit-box-shadow');

$csstidy_config['need_vendor_prefixes']['transition'] = array ('-moz-transition', '-webkit-transition', '-o-transition', '-ms-transition');
$csstidy_config['need_vendor_prefixes']['transition-delay'] = array ('-moz-transition-delay', '-webkit-transition-delay', '-o-transition-delay', '-ms-transition-delay');
$csstidy_config['need_vendor_prefixes']['transition-duration'] = array ('-moz-transition-duration', '-webkit-transition-duration', '-o-transition-duration', '-ms-transition-duration');
$csstidy_config['need_vendor_prefixes']['transition-property'] = array ('-moz-transition-property', '-webkit-transition-property', '-o-transition-property', '-ms-transition-property');
$csstidy_config['need_vendor_prefixes']['transition-timing-function'] = array ('-moz-transition-timing-function', '-webkit-transition-timing-function', '-o-transition-timing-function', '-ms-transition-timing-function');

$csstidy_config['need_vendor_prefixes']['@keyframes'] = array ('@-moz-keyframes', '@-webkit-keyframes', '@-o-keyframes', '@-ms-keyframes');

$csstidy_config['need_vendor_prefixes']['animation'] = array ('-moz-animation', '-webkit-animation', '-o-animation', '-ms-animation');
$csstidy_config['need_vendor_prefixes']['animation-delay'] = array ('-moz-animation-delay', '-webkit-animation-delay', '-o-animation-delay', '-ms-animation-delay');
$csstidy_config['need_vendor_prefixes']['animation-direction'] = array ('-moz-animation-direction', '-webkit-animation-direction', '-o-animation-direction', '-ms-animation-direction');
$csstidy_config['need_vendor_prefixes']['animation-duration'] = array ('-moz-animation-duration', '-webkit-animation-duration', '-o-animation-duration', '-ms-animation-duration');
$csstidy_config['need_vendor_prefixes']['animation-fill-mode'] = array ('-moz-animation-fill-mode', '-webkit-animation-fill-mode', '-o-animation-fill-mode', '-ms-animation-fill-mode');
$csstidy_config['need_vendor_prefixes']['animation-iteration-count'] = array ('-moz-animation-iteration-count', '-webkit-animation-iteration-count', '-o-animation-iteration-count', '-ms-animation-iteration-count');
$csstidy_config['need_vendor_prefixes']['animation-name'] = array ('-moz-animation-name', '-webkit-animation-name', '-o-animation-name', '-ms-animation-name');
$csstidy_config['need_vendor_prefixes']['animation-play-state'] = array ('-moz-animation-play-state', '-webkit-animation-play-state', '-o-animation-play-state', '-ms-animation-play-state');
$csstidy_config['need_vendor_prefixes']['animation-timing-function'] = array ('-moz-animation-timing-function', '-webkit-animation-timing-function', '-o-animation-timing-function', '-ms-animation-timing-function');

$csstidy_config['need_vendor_prefixes']['transform'] = array('-moz-transform', '-webkit-transform', '-o-transform', '-ms-transform');

$csstidy_config['need_vendor_prefixes']['background-size'] = array('-moz-background-size', '-webkit-background-size', '-o-background-size');
