<?php

declare(strict_types=1);
namespace Lhp\Imgverify;


/**
 * 图片管理
 * @package Lhaiping\Imgverify
 */
class Image
{
    const CANVAS_WIDTH = 340;

    const CANVAS_HEIGHT = 200;

    const CONCAVE_WIDTH = 50;

    const CONCAVE_HEIGHT = 50;

    /**
     * 获取随机的一张背景图片
     * @return string
     */
    public function getRandomBackground(): string
    {
        return dirname(__FILE__).'/asset/background_'.rand(1, 10);
    }

    /**
     * 获取凹面选择图片
     * @return string
     */
    public function getConcaveImage(): string
    {
        return dirname(__FILE__).'/asset/concave.png';
    }

    /**
     * 获取凹面的随机位置
     * @return array
     */
    public function getConcaveRandomPosition(): array
    {
        $maxHeight = static::CANVAS_HEIGHT - static::CONCAVE_HEIGHT;
        $maxWidth = static::CANVAS_WIDTH - static::CONCAVE_WIDTH;

        return [
            rand(100, $maxWidth),
            rand(40, $maxHeight - 40)
        ];
    }

    /**
     * 生成一张图片
     * @return array
     */
    public function createImage(): array
    {
        $backgroundImage = $this->getRandomBackground();
        $concaveImage = $this->getConcaveImage();
        $concaveImagePosition = $this->getConcaveRandomPosition();

        $canvas = imagecreatetruecolor(static::CANVAS_WIDTH, static::CANVAS_HEIGHT);
        $source = imagecreatefrompng($backgroundImage);
        $background = imagecopyresized($canvas, $source, 0, 0, 0, 0, static::CANVAS_WIDTH, static::CANVAS_HEIGHT);
        $image = imagecopyresized($background, $concaveImage, $concaveImagePosition[0], $concaveImagePosition[1], 0, 0, static::CONCAVE_WIDTH, static::CONCAVE_HEIGHT);
        ob_start();
        $imageData = ob_get_contents();
        ob_end_clean();
        imagedestroy($canvas);
        imagedestroy($source);
        imagedestroy($image);
        return [
            'concavePosition' => $concaveImagePosition,
            'image' => 'data:image/png;base64,' . base64_encode($imageData)
        ];
    }
}