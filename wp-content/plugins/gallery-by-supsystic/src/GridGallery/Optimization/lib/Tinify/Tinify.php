<?php
class Tinify_Tinify implements ImageOptimizeInterface {
	const VERSION = "1.4.0";

    private static $key = NULL;
    private static $appIdentifier = NULL;
    private static $proxy = NULL;

    private static $compressionCount = NULL;
    private static $client = NULL;

    public function __construct() {
	}

	public function setConfiguration($options) {
		if(!empty($options['auth_key'])) {
			Tinify_Tinify::setKey($options['auth_key']);
			return true;
		}
		return false;
	}

	public function optimizeImage($options) {

    	if(!empty($options['fileSrc']) && !empty($options['fileDest'])) {
			$source = Tinify_Source::fromFile($options['fileSrc']);
			return $source->toFile($options['fileDest']);
		}
		throw new Exception('Icorrect ImageOptimize Params');
	}

	public static function setKey($key) {
        self::$key = $key;
        self::$client = NULL;
    }

    public static function setAppIdentifier($appIdentifier) {
        self::$appIdentifier = $appIdentifier;
        self::$client = NULL;
    }

    public static function setProxy($proxy) {
        self::$proxy = $proxy;
        self::$client = NULL;
    }

    public static function getCompressionCount() {
        return self::$compressionCount;
    }

    public static function setCompressionCount($compressionCount) {
        self::$compressionCount = $compressionCount;
    }

    public static function getClient() {
        if (!self::$key) {
            throw new Tinify_AccountException("Provide an API key with Tinify\setKey(...)");
        }

        if (!self::$client) {
            self::$client = new Tinify_Client(self::$key, self::$appIdentifier, self::$proxy);
        }

        return self::$client;
    }

    public static function setClient($client) {
        self::$client = $client;
    }
}
/*
function setKey($key) {
    return Tinify_Tinify::setKey($key);
}

function setAppIdentifier($appIdentifier) {
    return Tinify_Tinify::setAppIdentifier($appIdentifier);
}

function setProxy($proxy) {
    return Tinify_Tinify::setProxy($proxy);
}

function getCompressionCount() {
    return Tinify_Tinify::getCompressionCount();
}

function compressionCount() {
    return Tinify_Tinify::getCompressionCount();
}

function fromFile($path) {
    return Tinify_Source::fromFile($path);
}

function fromBuffer($string) {
    return Tinify_Source::fromBuffer($string);
}

function fromUrl($string) {
    return Source::fromUrl($string);
}

function validate() {
    try {
		Tinify_Tinify::getClient()->request("post", "/shrink");
    } catch (Tinify_AccountException $err) {
        if ($err->status == 429) return true;
        throw $err;
    } catch (Tinify_ClientException $err) {
        return true;
    }
}
/**/
