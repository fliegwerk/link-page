<?php
/**
 * styles generator
 * by fliegwerk
 * (c) 2020. MIT License
 */

require_once "utility.php";

/**
 * Build a valid cascading style sheet to colorize sections and navigation items.
 *
 * @param string $classname the id or class name of the section
 * @param string $color the color of the section
 * @return string a valid cascading style sheet
 */
function build_color_styles(string $classname, string $color): string {
	return <<<"EOT"
.$classname::after,
#$classname li::after {
	background-color: $color;
}
#$classname header {
	border-color: $color;
}

EOT;
}

/**
 * Renders an image or placeholder if the image not in the path list.
 *
 * @param array $images
 * @param string $color
 * @param string $id
 * @param string $name
 * @return string
 */
function render_image(array $images, string $color, string $id, string $name): string {
	$filenames = array_map('get_filename', $images);
	$key = array_search($id, $filenames);
	if ($key === false) {
		// render svg placeholder
		$initials = get_initials($name);
		return <<<"EOT"
<svg viewBox="0 0 300 300">
	<rect x="0" y="0" width="300" height="300" style="fill: $color;"/>
	<text text-anchor="middle" x="150" y="210">$initials</text>
</svg>

EOT;
	} else {
		$path = $images[$key];
		// render img tag
		return "<img src=\"$path\" alt=\"$name logo\">";
	}
}
