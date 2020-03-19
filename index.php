<?php
function color($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
            $color[2].$color[3],
            $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

$imgs = array("img/file2.png", "img/file0.png", "img/file1.png","img/test.png","img/jpg.jpg");
$imgnum =4;
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

$name_color = 'ff0000';
if(isset($_GET["name_color"])){
    $name_color =$_GET["name_color"];
}

$hours = 0;
$minute = 0;
$seconds = 0;
$time = "03/20/2020 16:23:56";
if(isset($_GET["hours"])){
    $time =$_GET["hours"];
}
if(isset($_GET["minute"])){
    $time =$_GET["minute"];
}
if(isset($_GET["seconds"])){
    $time =$_GET["seconds"];
}
if(isset($_GET["date"])){
    $time =$_GET["date"].' '.$hours.':'.$minute.':'.$seconds;
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
$time_color = '00ff00';
if(isset($_GET["date_color"])){
    $time_color =$_GET["date_color"];
}
$timezone ='Asia/Dhaka';
if(isset($_GET["timezone"])){
    $timezone =$_GET["timezone"];
}
$bg_color ='ff0000';
if(isset($_GET["bg_color"])){
    $bg_color =$_GET["bg_color"];
}

date_default_timezone_set($timezone);
include 'GIFEncoder.class.php';

/*
$ext = end(explode('.', $imgs[$imgnum]));
$ext = strtolower($ext);*/
$ext = pathinfo($imgs[$imgnum], PATHINFO_EXTENSION);
$ext = strtolower($ext);

if($ext == 'png'){
    $ing_size = getimagesize($imgs[$imgnum]);
    $canva = imagecreate($ing_size[0],$ing_size[1]);
    imagecolorallocate($canva, color($bg_color)[0], color($bg_color)[1], color($bg_color)[2]); //png backgound r g b color
    imagejpeg($canva, 'temp/new.jpg');
    $bg_canvas = imagecreatefromjpeg('temp/new.jpg');
    $name_image = imagecreatefrompng($imgs[$imgnum]);

     imagecopy($bg_canvas, $name_image, 0, 0, 0, 0, $ing_size[0], $ing_size[1]);


    $name_font = array(
        'size'=>$name_font_size,
        'angle'=>$name_font_angle,
        'x-offset'=>$name_font_x,
        'y-offset'=>$name_font_y,
        'file'=> __DIR__.'/font/'.$name_font.'.ttf',
        'color'=>imagecolorallocate($bg_canvas, color($name_color)[0], color($name_color)[1], color($name_color)[2]),
    );
    imagettftext ($bg_canvas , $name_font['size'] , $name_font['angle'] , $name_font['x-offset'] , $name_font['y-offset'] , $name_font['color'] , $name_font['file'], $name );
    imagepng($bg_canvas, 'temp/new.png');
}

else if($ext == 'jpg'){
    $name_image = imagecreatefromjpeg($imgs[$imgnum]);
    $name_font = array(
        'size'=>$name_font_size,
        'angle'=>$name_font_angle,
        'x-offset'=>$name_font_x,
        'y-offset'=>$name_font_y,
        'file'=> __DIR__.'/font/'.$name_font.'.ttf',
        'color'=>imagecolorallocate($name_image, color($name_color)[0], color($name_color)[1], color($name_color)[2]),
    );
    imagettftext ($name_image , $name_font['size'] , $name_font['angle'] , $name_font['x-offset'] , $name_font['y-offset'] , $name_font['color'] , $name_font['file'], $name );
    imagepng($name_image, 'temp/new.png');

}


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
	'color'=>imagecolorallocate($image, color($time_color)[0],color($time_color)[1],color($time_color)[2]),
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
        $day = $interval->format('%a');
        if($day == 0 )
        {
            $text = $interval->format('%H:%I:%S');
        }
        else {
            $text = $interval->format('%a:%H:%I:%S');
        }
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

$gif = new AnimatedGif($frames,$delays,$loops);
$gif->getAnimation();
$gif->display();
$temp_png = 'temp/new.png';
unlink($temp_png);
$temp_jpg = 'temp/new.jpg';
unlink($temp_jpg);