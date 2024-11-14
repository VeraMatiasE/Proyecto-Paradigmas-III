<?php
function getRelativePath($levels, $path)
{
    $relativePath = str_repeat("../", $levels);
    return "$relativePath$path";
}