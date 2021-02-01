<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$data = Yaml::parseFile(__DIR__ . "/../source/channels.yaml");
$channels = $data['channels'];

$out = '#EXTM3U';

foreach ($channels as $key => $channel) {
	$logo = isset($channel['logo']) ? $channel['logo'] : 'default.png';

	if (!file_exists(__DIR__ . '/../assets/icons/' . $logo)) {
		throw new Exception("Logo not found for channel " . $channel['name']);
	}

	$temp = [
		"#EXTINF:-1",
		'tvg-id=""', 
		'tvg-name=""',
		'tvg-language="Burmese"', 
		'tvg-logo="https://raw.githubusercontent.com/nayzawoo/tv/main/assets/icons/'. $logo.'"',
		'group-title="",'
	];

	$out .= "\n" . implode(' ', $temp);
	$out .= $channel['name'];
	$out .= "\n" . $channel['url'];
}

file_put_contents(__DIR__ . '/../mm.m3u', $out);

echo "\033[32mDone! \n";

