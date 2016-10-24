<?php
namespace DwSetpoint\Libs\Helpers;
/**
 * Description of ImageHelper
 *
 * @author jdiaz
 */
class ImageHelper {
    
    public static function toFit ($source, $width, $height, $format = "png", $colorFill = "#000",  $opacityFill = 0, $getImagineImage = false) {
        $imagine = new \Imagine\Gd\Imagine();
        $size = new \Imagine\Image\Box($width, $height);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $resizeImg = $imagine->open($source)->thumbnail($size,$mode);
        $sizeR  = $resizeImg->getSize();
        $widthR = $sizeR->getWidth();
        $heightR = $sizeR->getHeight();
        $palette = new \Imagine\Image\Palette\RGB();
        $color = $palette->color($colorFill, $opacityFill);
        $preverse = $imagine->create($size, $color);
        $startX = $startY = 0;
        if($widthR < $width) {
            $startX = ($width - $widthR) / 2;
        }
        if($heightR < $height) {
            $startY = ($height - $heightR)/2;
        }
        $preverse->paste($resizeImg, new \Imagine\Image\Point($startX, $startY));
        if($getImagineImage){
            return $preverse;
        }
        return $data = $preverse->get($format);  
    }
    
}
