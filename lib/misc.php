<?php
function rasb_thumb($url, $width, $height=0, $align='') {
    return rasb_image_resize($url, $width, $height, true, $align, false);
}