<?php

function postArticle($onoma,$keimeno) {
	$post = curl_init();
	curl_setopt_array($post, array(
  CURLOPT_URL => 'http://apiproject.stage3.econtentsys.gr/wp-json/wp/v2/posts?content='.$keimeno.'&title='.$onoma.'&status=publish&categories=129',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic YXBpcHJvamVjdDphcGlwcm9qZWN0IzEy'
  ),
));
$article_post = curl_exec($post);
curl_close($post);
return json_decode($article_post, true);

}
