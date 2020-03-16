<?php
$imgs = array("img/file2.png", "img/file0.png", "img/file1.png");
$imgnum =2;
if(isset($_GET["img"])){
    $imgnum =$_GET["img"];
}
$name = 'shafiul islam';
if(isset($_GET["name"])){
    $name =$_GET["name"];
}
$name_font = 'DIGITALDREAM';
if(isset($_GET["name_font"])){
    $name_font =$_GET["name_font"];
}
$name_font_size = 20;
if(isset($_GET["name_size"])){
    $name_font_size =$_GET["name_size"];
}
$name_font_angle = 0;
if(isset($_GET["name_angle"])){
    $name_font_angle =$_GET["name_angle"];
}
$name_font_x = 20;
if(isset($_GET["name_x"])){
    $name_font_x =$_GET["name_x"];
}
$name_font_y = 500;
if(isset($_GET["name_y"])){
    $name_font_y =$_GET["name_y"];
}
$name_font_color_r = 255;
if(isset($_GET["name_r"])){
    $name_font_color_r =$_GET["name_r"];
}
$name_font_color_g = 100;
if(isset($_GET["name_g"])){
    $name_font_color_g =$_GET["name_g"];
}
$name_font_color_b = 255;
if(isset($_GET["name_b"])){
    $name_font_color_b =$_GET["name_b"];
}


$time = "03/25/2020";
if(isset($_GET["date"])){
    $time =$_GET["date"];
}
$time_font = 'DIGITALDREAM';
if(isset($_GET["date_font"])){
    $time_font =$_GET["date_font"];
}
$time_font_size = 30;
if(isset($_GET["date_size"])){
    $time_font_size =$_GET["date_size"];
}
$time_font_angle = 0;
if(isset($_GET["date_angle"])){
    $time_font_angle =$_GET["date_angle"];
}
$time_font_x = 30;
if(isset($_GET["date_x"])){
    $time_font_x =$_GET["date_x"];
}
$time_font_y = 70;
if(isset($_GET["date_y"])){
    $time_font_y =$_GET["date_y"];
}
$time_font_color_r = 255;
if(isset($_GET["date_r"])){
    $time_font_color_r =$_GET["date_r"];
}
$time_font_color_g = 100;
if(isset($_GET["date_g"])){
    $time_font_color_g =$_GET["date_g"];
}
$time_font_color_b = 255;
if(isset($_GET["date_b"])){
    $time_font_color_b =$_GET["date_b"];
}

$timezone ='Asia/Dhaka';
if(isset($_GET["timezone"])){
    $timezone =$_GET["timezone"];
}
/*if(isset($_GET["name"])){
    $name =$_GET["name"];
    $name_font_size = $_GET["name_size"];
    $name_font_angle = $_GET["name_angle"];
    $name_font_x = $_GET["name_x"];
    $name_font_y = $_GET["name_y"];
    $name_font_color_r = $_GET["name_r"];
    $name_font_color_g = $_GET["name_g"];
    $name_font_color_b = $_GET["name_b"];
}*/
date_default_timezone_set($timezone);
include 'GIFEncoder.class.php';

$name_image = imagecreatefrompng($imgs[$imgnum]);


$name_font = array(
    'size'=>$name_font_size,
    'angle'=>$name_font_angle,
    'x-offset'=>$name_font_x,
    'y-offset'=>$name_font_y,
    'file'=> __DIR__.'/font/'.$name_font.'.ttf',
    'color'=>imagecolorallocate($name_image, $name_font_color_r, $name_font_color_g, $name_font_color_b),
);
imagettftext ($name_image , $name_font['size'] , $name_font['angle'] , $name_font['x-offset'] , $name_font['y-offset'] , $name_font['color'] , $name_font['file'], $name );
imagepng($name_image, 'temp/new.png');

$time = "03/20/2020";

$future_date = new DateTime(date('r',strtotime($time)));
$time_now = time();
$now = new DateTime(date('r', $time_now));
 
//echo $time_now;
 
$frames = array();
$delays = array();

$image = imagecreatefrompng('temp/new.png');
$delay = 100; // milliseconds
$font = array(
	'size'=>$time_font_size,
	'angle'=>$time_font_angle,
	'x-offset'=>$time_font_x,
	'y-offset'=>$time_font_y,
    'file'=> __DIR__.'/font/'.$time_font.'.ttf',
	'color'=>imagecolorallocate($image, $time_font_color_r,$time_font_color_g,$time_font_color_b),
);
for($i = 0; $i <= 60; $i++){
	$interval = date_diff($future_date, $now);
	if($future_date < $now){

		// Open the first source image and add the text.
        $image = imagecreatefrompng('temp/new.png');
		$text =$interval->format('00:00:00:00');
		imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
		ob_start();
		imagegif($image);
		$frames[]=ob_get_contents();
		$delays[]=$delay;
                $loops = 1; 
		ob_end_clean();
		break;
	} else {
		// Open the first source image and add the text.
        $image = imagecreatefrompng('temp/new.png');
		$text = $interval->format('%a:%H:%I:%S');
		// %a is weird in that it doesn’t give you a two digit number
		// check if it starts with a single digit 0-9
		// and prepend a 0 if it does
		if(preg_match('/^[0-9]\:/', $text)){
			$text = '0'.$text;
		}
		imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text);
		ob_start();
		imagegif($image);
		$frames[]=ob_get_contents();
		$delays[]=$delay;
                $loops = 0;
		ob_end_clean();
	}
	$now->modify('+1 second');
}
//expire this image instantly
header( 'Expires: Sat, 26 Jul 2050 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' ); 
$gif = new AnimatedGif($frames,$delays,$loops);
$gif->getAnimation();
$gif->display();
$temp_file = 'temp/new.png';
unlink($temp_file);