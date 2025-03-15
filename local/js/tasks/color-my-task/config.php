<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/color-my-task.bundle.css',
	'js' => 'dist/color-my-task.bundle.js',
	'rel' => [
		'main.core',
	],
	'skip_core' => false,
];
