<?php


use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testImage()
    {
        $verify = new \Lhaiping\Imgverify\Image();
        $data = $verify->getImage();
        print_r($data);
    }
}
