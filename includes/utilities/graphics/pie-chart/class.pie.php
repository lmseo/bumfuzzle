<?php 
class simplepie 
{ 
    function __construct($width, $height, $dataArr) 
    { 
        $font = './verdana.ttf'; /** get it from c:/windows/fonts dir */ 
        $this->image = imagecreate($width,$height); 
        $piewidth = $width * 0.70;/* pie area */ 
        $x = round($piewidth/2); 
        $y = round($height/2); 
        $total = array_sum($dataArr); 
        $angle_start = 0; 
        $ylegend = 2; 
        imagefilledrectangle($this->image, 0, 0, $width, $piewidth, imagecolorallocate($this->image, 128, 128, 128)); 
        foreach($dataArr as $label=>$value) { 
            $angle_done    = ($value/$total) * 360; /** angle calculated for 360 degrees */ 
            $perc          = round(($value/$total) * 100, 1); /** percentage calculated */ 
            $color         = imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255)); 
            imagefilledarc($this->image, $x, $y, $piewidth, $height, $angle_start, $angle_done+= $angle_start, $color, IMG_ARC_PIE); 
            $xtext = $x + (cos(deg2rad(($angle_start+$angle_done)/2))*($piewidth/4)); 
            $ytext = $y + (sin(deg2rad(($angle_start+$angle_done)/2))*($height/4)); 
            imagettftext($this->image, 6, 0, $xtext, $ytext, imagecolorallocate($this->image, 0, 0, 0), $font, "$perc %"); 
            imagefilledrectangle($this->image, $piewidth+2, $ylegend, $piewidth+20, $ylegend+=20, $color); 
            imagettftext($this->image, 8, 0, $piewidth+22, $ylegend, imagecolorallocate($this->image, 0, 0, 0), $font, $label); 
            $ylegend += 4; 
            $angle_start = $angle_done; 
        } 
    } 
    function render() 
    { 
        header('Content-type: image/png'); 
        imagepng($this->image); 
    } 
}  
?>