<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/check-control-open-work-day.bundle.css',
	'js' => 'dist/check-control-open-work-day.bundle.js',
	'rel' => [
		'main.core', 'popup'
	],
	'skip_core' => false,
];
