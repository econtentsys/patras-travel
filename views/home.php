<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">
    <title>Wordpress Rest API Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.0/simplex/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>
html body { margin: 2% !important; }
.table {border: 1px solid black;width: 84%;padding: 1%;}
.table_vote {padding: 1%; width:16%;}
label, input, textarea { width:100%; }
</style>

<body>

	<section>
		<h1>Wordpress Rest API Project</h1>
		<p>
            <div style="color:red;">

            <form class="text-center m-5" id="article_submit" method="post" action="">
                    <label class="block">Τίτλος άρθρου<br><input id="titlos" type="text" name="title"></label>
                    <label class="block">Κείμενο άρθρου<br><textarea id="keimeno" rows="5" name="article"></textarea></label>
                    <button class="btn btn-primary block m-2" id="apostolh" type="button">ΑΠΟΣΤΟΛΗ</button>
            </form>

            </div>

            Φίλτρο Κατηγοριών: <select id="filter">
            <option value="Όλα τα άρθρα">Όλα τα άρθρα</option>
            <?php
            $t = 0;
            $r = 0;
            $s = 0;
            while ($t < count($pinakas))
            {
                while ($r < count($pinakas[$t]['_embedded']['wp:term'][0]))
                {
                    if (!empty($pinakas[$t]['_embedded']['wp:term'][0][$r]))
                    {
                        $pinakaskathgoriwn[] = $pinakas[$t]['_embedded']['wp:term'][0][$r]['name'];
                    }
                    $r++;
                }
                $r = 0;
                $t++;
            }
            $telikospinakaskathgoriwn = array_unique($pinakaskathgoriwn);
            while($s<count($telikospinakaskathgoriwn)){
                if (!empty($telikospinakaskathgoriwn[$s])){
                    echo "<option value='".$telikospinakaskathgoriwn[$s]."'>".$telikospinakaskathgoriwn[$s]."</option>";
                }
                $s++;
            }

            ?>
            </select>
        </p>
        <div id=box><?php
        $js_upvote = "";
        $js_downvote = "";
        //Δημιουργία πίνακα άρθρων
    while($i < count($pinakas)){
//     echo "<h3>Άρθρο ".$pinakas[$i]['id']."</h3>";
    echo "<div class='articles' style='display:flex;'><div class='table'>";
    echo "<span><b>ID Άρθρου:</b> ".$pinakas[$i]['id']."</span><br>";
    echo "<span><b>Όνομα Άρθρου:</b> ".$pinakas[$i]['title']['rendered']."</span><br>";
    echo "<span><b>Όνομα Αρθρογράφου:</b> ".$pinakas[$i]['_embedded']['author'][0]['name']."</span><br>";
    $categorynamesA = $pinakas[$i]['_embedded']['wp:term'][0];
        while($a < count($categorynamesA)){
            if (!empty($categorynamesA[$a])){
                $categorynamesB[] = $categorynamesA[$a]['name'];
            }
            $a++;
        }
    echo "<span><b>Κατηγορίες Άρθρου:</b> ".implode(",", $categorynamesB)."</span><br>";
    echo "<b>Περιγραφή (με αφαίρεση html tags και new lines):</b> ".trim(preg_replace('/\s+/', ' ', strip_tags($pinakas[$i]['content']['rendered'])))."<br>";
    $categorynamesB = [];
    $a = 0;
    echo "</div>
    <div class='table_vote'>
    <form id='article_submit' class='vote-form' method='post' action='' >
    <input type='hidden' name='article_id' value='".$pinakas[$i]['id']."'>

        <button id='upvote-".$pinakas[$i]['id']."' type='button' class='btn btn-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hand-thumbs-up' viewBox='0 0 16 16'>
    <path d='M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z'></path>
    </svg></button>
    <button id='downvote-".$pinakas[$i]['id']."' type='button' class='btn btn-danger'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hand-thumbs-down' viewBox='0 0 16 16'>
    <path d='M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856 0 .289-.036.586-.113.856-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a9.877 9.877 0 0 1-.443-.05 9.364 9.364 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964l-.261.065zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a8.912 8.912 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.224 2.224 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.866.866 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1z'/>
    </svg></button></form><br>
    <quote class='".$pinakas[$i]['id']."'> ";
    print_r("Βαθμολογία: ".$votes[$i]['vote']);
    echo "</quote>";
    //δημιουργία ajax για κάθε κουμπί
    $js_upvote .= "$('#upvote-".$pinakas[$i]['id']."').bind('click', function() { $.ajax({ url: '/test/vendor/sql.php?id=1&aid=".$pinakas[$i]['id']."', type: 'post', dataType: 'json' });  setTimeout(function(){window.location.reload(1);}, 10); }); ";
    $js_downvote .= "$('#downvote-".$pinakas[$i]['id']."').bind('click', function() { $.ajax({ url: '/test/vendor/sql.php?id=2&aid=".$pinakas[$i]['id']."',type: 'post',dataType: 'json' }); setTimeout(function(){ window.location.reload(1);}, 10);});";

    $i++;
    echo "</div>
        </div>
        <br>";
}
?></div>
<script> (function() {
        var pubnub = new PubNub({
            publishKey: 'pub-c-ddb3b594-303b-4f5b-a2e5-737b2ea2090d',
            subscribeKey: 'sub-c-1f361d6c-7354-441e-81e4-a0e931afa01d'
        });
        function $(id) {
            return document.getElementById(id);
        }
        var box = $('box'),
            input = $('input'),
            channel = 'orafok';
        pubnub.addListener({
            message: function(obj) {
                box.innerHTML = ('' + obj.message).replace(/[<>]/g, '') + '<br>' + box.innerHTML
            }
        });
        pubnub.subscribe({
            channels: [channel]
        });
        input.addEventListener('keyup', function(e) {
            if ((e.keyCode || e.charCode) === 13) {
                pubnub.publish({
                    channel: channel,
                    message: input.value,
                    x: (input.value = '')
                });
            }
        });
    })();
</script>
	</section>
	
	<script src="<?php if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') { $protocol = 'https://';} else { $protocol = 'http://';}
echo str_replace("public", "views",$protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], "", getcwd())); ?>/includes/ajax.js"></script>

<script>
<?= $js_upvote ?>
<?= $js_downvote ?>
  </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
		crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js"></script>

</body>

</html>
