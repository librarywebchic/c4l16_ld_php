<?php
require_once('vendor/autoload.php');

if (!class_exists('Guzzle')) {
	\Guzzle\Http\StaticClient::mount();
}

EasyRdf_Namespace::set('schema', 'http://schema.org/');

$guzzleOptions = array(
	'headers' => array(
			'Accept' => 'text/plain',
			'User-Agent' => 'code4lib_ld_preconf_demo'
	)
);

$uri = 'http://www.worldcat.org/oclc/82671871';

try {
	$response = \Guzzle::get($uri, $guzzleOptions);
	$graph = new EasyRdf_Graph();
	$graph->parse($response->getBody(true));
	$bib = $graph->resource($uri);
	
	print $bib->get('schema:name')->getValue() . "\n";
	
	foreach ($bib->all('schema:author') as $author) {
		print $author->get('schema:name') . "\n";
	}
	
	foreach ($bib->all('schema:creator') as $creator) {
		print $creator->get('schema:name') . "\n";
	}
	
	foreach ($bib->all('schema:about') as $subject) {
		print $subject->get('schema:name') . "\n";
	}
	
	foreach ($bib->all('schema:description') as $description) {
		print $description . "\n";
	}
	

} catch (\Guzzle\Http\Exception\BadResponseException $error) {
	return 'Whoops I did not get a successful HTTP response';
}

