<?php

include_once dirname(__FILE__) . '/image_view_column.php';
include_once dirname(__FILE__) . '/view_column_utils.php';

class ExternalImageViewColumn extends ImageViewColumn
{

    /** @var string */
    private $height = '';
    /** @var string */
    private $width = '';

    /**
     * @param string $value
     */
    public function setHeight($value)
    {
        $this->height = $value;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $value
     */
    public function setWidth($value)
    {
        $this->width = $value;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    public function GetImageLink()
    {
        return $this->getWrappedValue();
    }

    public function Accept($renderer)
    {
        $renderer->RenderImageViewColumn($this);
    }

    public function generateImageSizeString() {
        return generateDimensionString($this->height, $this->width);
    }

}