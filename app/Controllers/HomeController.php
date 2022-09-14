<?php 
namespace App\Controllers;
require_once APP_ROOT . '/vendor/sql.php';

use App\Models\Home;
use Symfony\Component\Routing\RouteCollection;


class HomeController {
	public function indexAction(RouteCollection $routes) {
		$routeToProduct = str_replace('{id}', 1, $routes->get('product')->getPath());

		$get_articles = curl_init();
		curl_setopt_array($get_articles, array(
		CURLOPT_URL => 'http://apiproject.stage3.econtentsys.gr/wp-json/wp/v2/posts?_embed=wp:term,author',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$apanthsh = curl_exec($get_articles);
		curl_close($get_articles);
		$pinakas = json_decode($apanthsh, true);

		$i = 0;
		$a = 0;
 		$votes = array();
 		foreach ($pinakas as $item) {
 			array_push($votes, array(
 			"id" => $item['id'],
 			"vote" => getVotes($item['id'])));
 		};
 		//print_r($votes);

        require_once APP_ROOT . '/views/home.php';

	}


}
