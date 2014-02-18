<?php
require('phpQuery/phpQuery/phpQuery.php');
set_time_limit(3600);

$link_page = array();
for ($i = 0; $i < 300; $i = $i + 25)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.douban.com/group/shanghaizufang/discussion?start='.$i);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($ch);
	curl_close($ch);

	$doc = phpQuery::newDocument($html);

	$links = array();
	$titleElement = pq('.article > div:eq(1)')->find('td.title > a');
	foreach($titleElement as $title)
	{
		$links[] = pq($title)->attr('href');
	}

	foreach ($links as $link)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$link_page[$link] = curl_exec($ch);
		curl_close($ch);
		sleep(1);
	}	
}

file_put_contents('pageInfo', json_encode($link_page));
echo 'success';