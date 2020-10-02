<?php
/**
 * config parser
 * by fliegwerk
 * (c) 2020. MIT License
 */

require_once "definitions.php";
require_once "utility.php";

function parse_config() {
	$root_props = array(
		"title" => "htmlEntities",
		"sections" => null
	);
	$section_props = array(
		"name" => "htmlEntities",
		"color" => "parse_html_color",
		"links" => null
	);
	$link_props = array(
		"name" => "htmlEntities",
		"description" => "htmlEntities",
		"url" => null
	);

	if (!file_exists(CONFIG_PATH))
		throw new Exception("Config file not found. Current lookup path: ". CONFIG_PATH);

	$config = json_decode(file_get_contents(CONFIG_PATH));
	if (!isset($config)) throw new ErrorException(json_last_error_msg(), json_last_error());

	foreach ($root_props as $prop => $converter) {
		if (!isset($config->$prop))	throw new Exception("Config missing property \"" . $prop . "\"");

		if (!is_null($converter)) $config->$prop = $converter($config->$prop);
	}

	if (!is_array($config->sections)) throw new Exception("Invalid type for \"sections\". Must be an array");

	$section_num = 0;
	foreach ($config->sections as &$section) {
		foreach($section_props as $prop => $converter) {
			if (!isset($section->$prop))
				throw new Exception("Section " . $section_num . " missing property \"". $prop . "\"");

			if (is_callable($converter)) $section->$prop = $converter($section->$prop);
		}

		if (!is_array($section->links))
			throw new Exception("Invalid type for \"links\" in section " . $section_num . ". Must be an array");


		foreach ($section->links as &$link) {
			$link_num = 0;
			foreach ($link_props as $prop => $converter) {
				if (!isset($link->$prop))
					throw new Exception(
						"Link " . $link_num . " in section " . $section->name . " missing property \"" . $prop . "\""
					);

				if (!is_null($converter)) $link->$prop = $converter($link->$prop);

				$link->id = gen_id($link->name);
				++$link_num;
			}
		}

		$section->id = gen_id($section->name);
		++$section_num;
	}

	return $config;
}