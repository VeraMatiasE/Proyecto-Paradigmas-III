<?php
function htmlToJson($html)
{
    $dom = new DOMDocument();

    libxml_use_internal_errors(true);
    $html = '<?xml encoding="UTF-8" ?>' . $html;
    @$dom->loadHTML($html);

    $allowedTags = ['b', 'i', 'u', 'a', 'img', 'h1', 'h2', 'p', 'div', 'ul', 'ol', 'li'];

    $convertNode = function ($node) use (&$convertNode, $allowedTags) {

        if ($node->nodeType == XML_TEXT_NODE) {
            return $node->nodeValue;
        }

        if (!in_array($node->nodeName, $allowedTags)) {
            return null;
        }

        $jsonNode = [
            'tag' => $node->nodeName,
            'attributes' => [],
            'children' => []
        ];

        foreach ($node->attributes as $attr) {
            $jsonNode['attributes'][$attr->nodeName] = $attr->nodeValue;
        }

        foreach ($node->childNodes as $child) {
            $childJson = $convertNode($child);
            if ($childJson) {
                $jsonNode['children'][] = $childJson;
            }
        }

        return $jsonNode;
    };

    $body = $dom->getElementsByTagName('body')->item(0);
    $jsonContent = [];

    foreach ($body->childNodes as $child) {
        $childJson = $convertNode($child);
        if ($childJson) {
            $jsonContent[] = $childJson;
        }
    }

    return json_encode($jsonContent, JSON_UNESCAPED_UNICODE);
}

function jsonToHtml($json)
{
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;

    $htmlElement = $dom->createElement('html');
    $bodyElement = $dom->createElement('body');
    $htmlElement->appendChild($bodyElement);
    $dom->appendChild($htmlElement);

    $convertNode = function ($node, $parentNode) use ($dom, &$convertNode) {
        if (is_array($node)) {
            if (isset($node['tag'])) {
                $tag = $node['tag'];
                $newElement = $dom->createElement($tag);

                if (isset($node['attributes']) && is_array($node['attributes'])) {
                    foreach ($node['attributes'] as $attrName => $attrValue) {
                        $newElement->setAttribute($attrName, $attrValue);
                    }
                }

                if (isset($node['children']) && is_array($node['children'])) {
                    foreach ($node['children'] as $child) {
                        $convertNode($child, $newElement);
                    }
                }

                $parentNode->appendChild($newElement);
            }
        } else {
            $parentNode->appendChild($dom->createTextNode($node));
        }
    };

    foreach ($json as $node) {
        $convertNode($node, $bodyElement);
    }

    return $dom->saveHTML();
}