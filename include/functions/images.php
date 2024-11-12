<?php

function uploadImages($images, $uploadDir, $isBanner = false)
{
    $imageUrls = [];
    foreach ($images as $index => $image) {
        $imgTmp = $image['tmp_name'];
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid(date('YmdHis')) . bin2hex(random_bytes(5)) . '.' . $extension;
        $targetImg = "$uploadDir/$filename";

        if (move_uploaded_file($imgTmp, $targetImg)) {
            $imageUrls[] = $isBanner && $index === 0 ? $filename : $targetImg;
        }
    }
    return $imageUrls;
}

function replaceImageUrls($content, $imageUrls, $files)
{
    foreach ($imageUrls as $index => $url) {
        $tempUrl = $files[$index]['name'];
        $content = str_replace($tempUrl, $url, $content);
    }
    return $content;
}
