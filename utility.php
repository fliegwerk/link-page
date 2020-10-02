<?php
/**
 * utility functions
 * by fliegwerk
 * (c) 2020. MIT License
 */

/**
 * Removes all non ascii and html compatible characters and replace them with an underscore.
 *
 * @param string $str the input string
 * @return string the replaced string
 */
function remove_non_ascii(string $str): string {
	return preg_replace("/[^a-zA-Z0-9-._]/", "_", $str);
}

/**
 * Generates an element id that is compatible with the html attribute `id`.
 *
 * @param string $str the source string
 * @return string the generated id
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/id
 */
function gen_id(string $str): string {
	$id = strtolower(remove_non_ascii(trim($str)));
	// compatibility
	return preg_match("/[^a-z]/", $id[0]) ? substr_replace($id, "_", 0, 1) : $id;
}

/**
 * Converts a string to a valid html hexadecimal color.
 *
 * @param string $color the string with the hex color
 * @return string a valid hexadecimal color
 */
function parse_html_color(string $color): string {
	if (preg_match('/^#?(?:[0-9a-fA-F]{3}){1,2}$/', $color)) {
		if ($color[0] !== '#') return '#' . $color;
		return $color;
	}
	throw new Exception("Color has invalid format: " . $color);
}

/**
 * Generates the one character initials from a string.
 *
 * @param string $str the string to get the initials from
 * @return string the initials from the string
 */
function get_initials(string $str): string {
	return strtoupper($str[0]) ?? "_";
}

/**
 * Returns the filename of a path.
 *
 * @param string $path the path to cut down
 * @return string the filename of file specified by the path
 */
function get_filename(string $path): string {
	return pathinfo($path)["filename"];
}
