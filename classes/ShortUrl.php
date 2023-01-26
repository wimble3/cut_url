<?php

namespace classes;

require_once 'Config.php';

class ShortUrl
{
    const FILE_PATH = '/db/db.csv';
    const FILE_SEPARATOR = ';';
    private static array|false $file;

    public static function generateResponse($url): string
    {
        $url = str_replace(' ', '', $url);

        if (self::isValidUrl($url)) {
            $shortUrl = self::selectShortUrl($url);
            if (!$shortUrl) {
                return self::createShortUrl($url);
            }
            return $shortUrl;
        }
        return 'Invalid URL';
    }

    private static function isValidUrl($url): bool
    {
        return !empty($url) && get_headers($url, 1) !== false;
    }

    private static function createShortUrl($url): string
    {
        $row = ["\n" . $url,];
        $row[] = self::generateShortUrl($url);
        $row[] = 0;

        file_put_contents(
            $_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH,
            implode(self::FILE_SEPARATOR, $row),
            FILE_APPEND
        );
        return $row[1];
    }

    private static function generateShortUrl($url): string
    {
        return Config::PROTOCOL . Config::HOSTNAME . ':' . Config::PORT . '/?t=' . self::generateToken($url);
    }

    private static function generateToken($url): string
    {
        return mb_substr(md5($url), 0, 6);
    }

    private static function selectShortUrl($url): false|string
    {
        $arr = self::getFileToArray();

        if (array_key_exists($url, $arr)) {
            return $arr[$url][1];
        }
        return false;
    }

    private static function getFileToArray(): array
    {
        $arr = [];
        self::$file = file($_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH);

        foreach (self::$file as $row) {
            $row = explode(self::FILE_SEPARATOR, $row);
            $arr[$row[0]] = $row;
        }
        return $arr;
    }

    public static function catchUrl($token): void
    {
        $arr = self::getFileToArray();
        foreach ($arr as $row) {
            if ($row[1] === Config::PROTOCOL . Config::HOSTNAME . ':' . Config::PORT . '/?t=' . $token) {
                header('Location: ' . $row[0]);
                die();
            }
        }
    }
}
