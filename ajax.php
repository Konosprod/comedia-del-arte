<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);

$template = $twig->loadTemplate("list.twig");

if(isset($_POST["url"])) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$url = $_POST["url"];
	$videoId = explode("/", str_replace("https://www.arte.tv/fr/videos/", "", $url))[0];

	curl_setopt($ch, CURLOPT_URL,"https://api.arte.tv/api/player/v1/config/fr/".$videoId);

	$res = curl_exec($ch);
	$json = json_decode($res, true);

	curl_close($ch);

	echo $template->render($json["videoJsonPlayer"]);
}
