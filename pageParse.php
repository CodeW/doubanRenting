<?php
header("Content-type: text/html; charset = utf-8");
require('phpQuery/phpQuery/phpQuery.php');
set_time_limit(3600);

$pages = file_get_contents('pageInfo');
$pages = json_decode($pages);

$greatPage = array();
foreach ($pages as $link=>$page)
{
	$doc = phpQuery::newDocument($page);
	$dateElement = pq('.article > .topic-content > .topic-doc > h3 > span:eq(1)');
	$publisDate = trim($dateElement->html());
	$title = pq('#content > h1')->html();
	$content = pq('.article > .topic-content > .topic-doc')->html();
	if (strpos($title, '求租') !== false || strpos($content, '求租') !== false)
	{
		continue;
	}
	
	$greatPage[$publisDate]['title'] = $title;
	$greatPage[$publisDate]['link'] = "<a target='_blank' href='{$link}'>{$link}</a>";
	$greatPage[$publisDate]['body'] = $content;
}

krsort($greatPage);

echo "<ul style='font-size: 14px;'>";
foreach ($greatPage as $page)
{
	echo "<li style='margin-bottom: 50px;'>";
	echo $page['title'];
	echo "<br />";
	echo $page['link'];
	echo "<br />";
	echo $page['body'];
	echo "</li>";
}
echo "</ul>";
