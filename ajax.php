<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/ShortUrl.php';

echo \classes\ShortUrl::generateResponse($_POST['url']);
