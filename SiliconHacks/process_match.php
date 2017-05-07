<?php

$servername = "db680777377.db.1and1.com";
$username = "dbo680777377";
$password = "siliconhacks";
$dbname = "db680777377";

// Create connection
mysql_connect($servername, $username, $password);
@mysql_select_db($dbname) or die ("Issue while trying to access the database");

#$user_ip = $_SERVER['REMOTE_ADDR'];
#$profile_pic = (empty($_POST["match_picture"])) ? "http://acti-pingouin.fr/SiliconHacks/my_avatar.jpeg" : $_POST["match_picture"];

if(isset($_FILES['match_picture'])){
	$errors= array();
	$file_name = $_FILES['match_picture']['name'];
	$file_size =$_FILES['match_picture']['size'];
	$file_tmp =$_FILES['match_picture']['tmp_name'];
	$file_type=$_FILES['match_picture']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['match_picture']['name'])));

	$expensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$expensions)=== false){
	 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}

	if($file_size > 2097152){
	 $errors[]='File too big';
	}

	if(empty($errors)==true){
	 move_uploaded_file($file_tmp,"images/".$file_name);
	 #echo "Success";
	}else{
	 print_r($errors);
	}
	$profile_pic = "images/".$file_name;
}

else
{
	$profile_pic = "http://acti-pingouin.fr/SiliconHacks/my_avatar.jpeg";
}

$infos = array();

$infos[0] = (empty($_POST["match_interest1"])) ? "Pinguin" : $_POST["match_interest1"];
$infos[1] = (empty($_POST["match_interest2"])) ? "Pinguin" : $_POST["match_interest2"];
$infos[2] = (empty($_POST["match_interest3"])) ? "Pinguin" : $_POST["match_interest3"];
$infos[3] = (empty($_POST["match_interest4"])) ? "Pinguin" : $_POST["match_interest4"];
$infos[4] = (empty($_POST["match_interest5"])) ? "Pinguin" : $_POST["match_interest5"];

$result_urls = array();

for ($i = 0; $i < 5; $i++)
{
	$bodytag = str_replace(" ", "%20", $infos[$i]);

	$url = "http://api.ababeen.com/api/images.php?q=" . $bodytag;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, "http://www.acti-pingouin.fr");
	$body = curl_exec($ch);
	curl_close($ch);

	$json = json_decode($body);
	$image_url = $json[0]->url;
	$result_urls[$i] = $image_url;
	#echo $image_url;
}

$time = time();

$query = "REPLACE INTO `match` SET profile_url = '" . $profile_pic . 
		 "', pref_url_1 = '" . $result_urls[0] .
		 "', pref_url_2 = '" . $result_urls[1] .
		 "', pref_url_3 = '" . $result_urls[2] .
		 "', pref_url_4 = '" . $result_urls[3] .
		 "', pref_url_5 = '" . $result_urls[4] .
		 "', time = '" . $time . "' ;";
#echo "<br/>";
#echo $query;
mysql_query($query);


mysql_close();

header("Location: http://www.acti-pingouin.fr/SiliconHacks/game.php?id=" . $time,TRUE,302);
#echo "allo";
?>