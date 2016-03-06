<?php 

/**
* Class name: Create Miniature 
* Function: generate multiple types of thumbnail 
* basic parameters: $ srcFile, $ echoType 
* method used parameters: 
* $ toFile, the resulting file 
* $ toW, generated wide $ toH, generate high * 
* $ bk1, background color parameter to 255 as the highest 
* $ bk2, background color parameters * $ bk3, background color parameters * 
* examples: * include ( 'thumb.php'); * $ cm = new CreatMiniature () ; 
* $ cm-> SetVar ( '1.jpg', 'file'); 
* $ cm-> Distortion ( 'dis_bei.jpg', 150,200); 
* $ cm-> Prorate ( 'pro_bei.jpg', 150,200) ; 
// incidental cutting 
* $ cm-> cut ( 'cut_bei.jpg', 150,200); 
* $ cm-> BackFill ( 'fill_bei.jpg', 150,200);
 */
class CreatMiniature {
	// Public variables
	var $srcFile = '';	//Artwork
	var $echoType;		//Output image type, link-- not saved as a file; file-- saved as files
	var $im = '';		//Temporary variable
	var $srcW = '';		//Original width
	var $srcH = '';		//Original highth  
	// And set the variable initialization
	function SetVar($srcFile, $echoType){
		$this->srcFile = $srcFile;
		$this->echoType = $echoType;

		$info = '';
		$data = GetImageSize($this->srcFile, $info);
		switch ($data[2]) {
			case 1:
				if (!function_exists('imagecreatefromgif')) {
					exit();
				} 
				$this->im = ImageCreateFromGIF($this->srcFile);
				break;
			case 2:
				if (!function_exists('imagecreatefromjpeg')) {
					exit();
				} 
				$this->im = ImageCreateFromJpeg($this->srcFile);
				break;
			case 3:
				$this->im = ImageCreateFromPNG($this->srcFile);
				break;
		} 
		$this->srcW = ImageSX($this->im);
		$this->srcH = ImageSY($this->im);
	} 
	// Generating twisted Thumbnail
	function Distortion($toFile, $toW, $toH){
		$cImg = $this->CreatImage($this->im, $toW, $toH, 0, 0, 0, 0, $this->srcW, $this->srcH);
		return $this->EchoImage($cImg, $toFile);
		ImageDestroy($cImg);
	} 
	// Generates scaled thumbnail
	function Prorate($toFile, $toW, $toH){
		$toWH = $toW / $toH;
		$srcWH = $this->srcW / $this->srcH;
		if ($toWH<=$srcWH) {
			$ftoW = $toW;
			$ftoH = $ftoW * ($this->srcH / $this->srcW);
		} else {
			$ftoH = $toH;
			$ftoW = $ftoH * ($this->srcW / $this->srcH);
		} 
		if ($this->srcW > $toW || $this->srcH > $toH) {
			$cImg = $this->CreatImage($this->im, $ftoW, $ftoH, 0, 0, 0, 0, $this->srcW, $this->srcH);
			return $this->EchoImage($cImg, $toFile);
			ImageDestroy($cImg);
		} else {
			$cImg = $this->CreatImage($this->im, $this->srcW, $this->srcH, 0, 0, 0, 0, $this->srcW, $this->srcH);
			return $this->EchoImage($cImg, $toFile);
			ImageDestroy($cImg);
		} 
	} 
	// Thumbnail produce the smallest cropped
	function Cut($toFile, $toW, $toH){
		$toWH = $toW / $toH;
		$srcWH = $this->srcW / $this->srcH;
		if ($toWH<=$srcWH) {
			$ctoH = $toH;
			$ctoW = $ctoH * ($this->srcW / $this->srcH);
		} else {
			$ctoW = $toW;
			$ctoH = $ctoW * ($this->srcH / $this->srcW);
		} 
		$allImg = $this->CreatImage($this->im, $ctoW, $ctoH, 0, 0, 0, 0, $this->srcW, $this->srcH);
		$cImg = $this->CreatImage($allImg, $toW, $toH, 0, 0, ($ctoW - $toW) / 2, ($ctoH - $toH) / 2, $toW, $toH);
		return $this->EchoImage($cImg, $toFile);
		ImageDestroy($cImg);
		ImageDestroy($allImg);
	} 
	// It is filled with a transparent true color thumbnails generated background fill, to fill the remaining space with the default white to pass $ isAlpha
	function BackFill($toFile, $toW, $toH,$isAlpha=false,$red=255, $green=255, $blue=255){
		$toWH = $toW / $toH;
		$srcWH = $this->srcW / $this->srcH;
		if ($toWH<=$srcWH) {
			$ftoW = $toW;
			$ftoH = $ftoW * ($this->srcH / $this->srcW);
		} else {
			$ftoH = $toH;
			$ftoW = $ftoH * ($this->srcW / $this->srcH);
		} 
		if (function_exists('imagecreatetruecolor')) {
			@$cImg = ImageCreateTrueColor($toW, $toH);
			if (!$cImg) {
				$cImg = ImageCreate($toW, $toH);
			} 
		} else {
			$cImg = ImageCreate($toW, $toH);
		}
		

		$fromTop = ($toH - $ftoH)/2;//Filling from the middle
		$backcolor = imagecolorallocate($cImg,$red,$green, $blue); //Filled with the background color
		if ($isAlpha){//Filled with a transparent color
			$backcolor=ImageColorTransparent($cImg,$backcolor);
			$fromTop = $toH - $ftoH;//Filling from the bottom
		}		

		ImageFilledRectangle($cImg, 0, 0, $toW, $toH, $backcolor);
		if ($this->srcW > $toW || $this->srcH > $toH) {
			$proImg = $this->CreatImage($this->im, $ftoW, $ftoH, 0, 0, 0, 0, $this->srcW, $this->srcH);
			if ($ftoW < $toW) {
				ImageCopy($cImg, $proImg, ($toW - $ftoW) / 2, 0, 0, 0, $ftoW, $ftoH);
			} else if ($ftoH < $toH) {
				ImageCopy($cImg, $proImg, 0, $fromTop, 0, 0, $ftoW, $ftoH);
			} else {
				ImageCopy($cImg, $proImg, 0, 0, 0, 0, $ftoW, $ftoH);
			} 
		} else {
			ImageCopyMerge($cImg, $this->im, ($toW - $ftoW) / 2,$fromTop, 0, 0, $ftoW, $ftoH, 100);
		} 
		return $this->EchoImage($cImg, $toFile);
		ImageDestroy($cImg);
	} 

	function CreatImage($img, $creatW, $creatH, $dstX, $dstY, $srcX, $srcY, $srcImgW, $srcImgH){
		if (function_exists('imagecreatetruecolor')) {
			@$creatImg = ImageCreateTrueColor($creatW, $creatH);
			if ($creatImg)
				ImageCopyResampled($creatImg, $img, $dstX, $dstY, $srcX, $srcY, $creatW, $creatH, $srcImgW, $srcImgH);
			else {
				$creatImg = ImageCreate($creatW, $creatH);
				ImageCopyResized($creatImg, $img, $dstX, $dstY, $srcX, $srcY, $creatW, $creatH, $srcImgW, $srcImgH);
			} 
		} else {
			$creatImg = ImageCreate($creatW, $creatH);
			ImageCopyResized($creatImg, $img, $dstX, $dstY, $srcX, $srcY, $creatW, $creatH, $srcImgW, $srcImgH);
		} 
		return $creatImg;
	} 
	// Output image, link --- output only, without saving the file. file-- saved as files
	function EchoImage($img, $to_File){
		switch ($this->echoType) {
			case 'link':return ImagePNG($img);break;				
			case 'file':return ImagePNG($img, $to_File);break;
			//return ImageJpeg($img, $to_File);				
		} 
	} 
}
