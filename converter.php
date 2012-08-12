<?php

$im = imagecreatefrompng("img/ninja.png");
$img_heigh = imagesy($im); 
$img_width = imagesx($im);

$r = array();
$g = array();
$b = array();
$xx = array();
$yy = array();

for($y=0;$y<$img_heigh;$y++){
  for($x=0;$x<$img_width;$x++){
    $color_index = imagecolorat($im, $x, $y);

// make it human readable
	$color = imagecolorsforindex($im, $color_index);
//print_r($color);
	//var_dump($r, $g, $b);
	if($color['alpha']==0) {
		$_r = dechex($color['red']);
		$_g = dechex($color['green']);
		$_b = dechex($color['blue']);
        
        if(strlen($_r)==1) {
            $_r = "0".$_r;
        }
        $r[] = strtoupper($_r);
        if(strlen($_g)==1) {
            $_g = "0".$_g;
        }
        $g[] = strtoupper($_g);
        if(strlen($_b)==1) {
            $_b = "0".$_b;
        }
        $b[] = strtoupper($_b);
        
		$xx[] = 10 * $x - ( 10 * (ceil($img_width / 2)));
		$yy[] = 10 * $y - ( 10 * (ceil($img_heigh / 2)));
	}
  }
}

$color = array();
$coord = array();
foreach($r as $k => $v) {
    
    $color[] = $r[$k].$g[$k].$b[$k];
    $coord[] = "[".$xx[$k].",".$yy[$k]."]";
}

echo "var img_color = ['".implode("','", $color)."'];\n\n";
echo "var img_coord = [".implode(",", $coord)."];";

?>
