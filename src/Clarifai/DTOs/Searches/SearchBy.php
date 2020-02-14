<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;

/**
 * A collection of various methods by which to search for inputs.
 */
abstract class SearchBy
{
    public abstract function serialize();

    public static function conceptID($conceptID)
    {
        return new SearchByConceptID('output', $conceptID);
    }

    public static function userTaggedConceptID($conceptID)
    {
        return new SearchByConceptID('input', $conceptID);
    }

    public static function conceptName($conceptName)
    {
        return new SearchByConceptName('output', $conceptName);
    }

    public static function userTaggedConceptName($userTaggedConceptName)
    {
        return new SearchByConceptName('input', $userTaggedConceptName);
    }

    /**
     * A search clause that will match inputs that had images with the given URL.
     *
     * Note: This is NOT a visual-similarity search. This is a simple string search for the given
     * image's URL. For visual similarity please use SearchBy::imageVisually.
     *
     * @param string $imageURL The URL of the image to search by.
     * @return SearchByImageURL A new SearchBy instance.
     */
    public static function imageURL($imageURL)
    {
        return new SearchByImageURL($imageURL);
    }

    /**
     * @param string $imageUrl The image URL.
     * @return SearchByURLImageVisually A new SearchBy instance.
     */
    public static function urlImageVisually($imageUrl)
    {
        return new SearchByURLImageVisually($imageUrl);
    }

    /**
     * @param string $fileContent Image file content encoded as base64.
     * @return SearchByFileImageVisually A new SearchBy instance.
     */
    public static function fileImageVisually($fileContent)
    {
        return new SearchByFileImageVisually($fileContent);
    }

    // TODO (Rok) HIGH: Search by metadata.

    /**
     * @param GeoPoint $geoPoint The geo point.
     * @param GeoRadius $geoRadius The geo radius.
     * @return SearchByGeoCircle
     */
    public static function geoCircle($geoPoint, $geoRadius)
    {
        return new SearchByGeoCircle($geoPoint, $geoRadius);
    }

    /**
     * Inputs will be filtered to a box geo area from the uppermost point to the lowermost point
     * and the leftmost point to the rightmost point.
     *
     * @param GeoPoint $geoPoint1 The first geo point.
     * @param GeoPoint $geoPoint2 The second geo point.
     * @return SearchByGeoRectangle
     */
    public static function geoRectangle($geoPoint1, $geoPoint2)
    {
        return new SearchByGeoRectangle($geoPoint1, $geoPoint2);
    }

    /**
     * After you have added inputs with custom metadata, you can search by that metadata.
     * You can exact-match any key-value pair no matter how nested it is.
     * @param $metadata
     * @return SearchByMetadata
     */
    public static function metadata($metadata)
    {
        return new SearchByMetadata($metadata);
    }
}
