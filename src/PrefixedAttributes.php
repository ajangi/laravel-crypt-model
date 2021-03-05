<?php


namespace LaravelCryptModel;

use ErrorException;
use LaravelCryptModel\Encode\LaravelCryptEncoder;
use LaravelCryptModel\Exceptions\ModelNotFoundForPrefix;
use LaravelCryptModel\Exceptions\PrefixNotFoundForModel;
use LaravelCryptModel\Exceptions\RegisteredModelsNotStructured;
use LaravelCryptModel\Logger\LaravelCryptLogger;

class PrefixedAttributes
{
    public static $registeredModels = [];

    /**
     * @param array $registerModels
     * @throws RegisteredModelsNotStructured
     */
    public static function registerModels(array $registerModels): void
    {
        foreach ($registerModels as $model_name => $item){
            self::registerModel($model_name, $item);
        }
    }

    /**
     * @param string $model_name
     * @param array $item
     * @throws RegisteredModelsNotStructured
     */
    public static function registerModel(string $model_name, array $item)
    {
        foreach ($item['attributes'] as $attribute){
            try {
                static::$registeredModels[$model_name.'_'.$attribute.'_']['model'] = $item['model'];
                static::$registeredModels[$model_name.'_'.$attribute.'_']['model_name'] = $model_name;
            }catch (RegisteredModelsNotStructured $exception){
                LaravelCryptLogger::makeExceptionLog($exception);
                throw RegisteredModelsNotStructured::make($item['model'], $attribute);
            }
        }
    }

    public static function clearRegisteredModels(): void
    {
        static::$registeredModels = [];
    }

    /**
     * @param string $model
     * @param string $attribute
     * @return string|null
     * @throws PrefixNotFoundForModel
     */
    public static function getPrefixForModel(string $model, string $attribute): ?string
    {
        $array = static::getAllRegisteredPrefixesForModel($model);
        try {
            foreach ($array as $prefix => $item){
                if(preg_replace('/'.$item['model_name'].'_'.'/','',$prefix) === $attribute.'_'){
                    return $prefix;
                }
            }
        }catch (PrefixNotFoundForModel $exception){
            LaravelCryptLogger::makeExceptionLog($exception);
            throw PrefixNotFoundForModel::make($item['model'], $attribute);
        }
        return null;
    }

    /**
     * @param $model
     * @return array
     */
    public static function getAllRegisteredPrefixesForModel($model): array
    {
        return array_filter(static::$registeredModels,function ($element)use($model){
            return ($element['model'] === $model);
        });
    }

    /**
     * @param string $prefix
     * @return mixed|null
     */
    public static function getModelClass(string $prefix)
    {
        return static::$registeredModels[$prefix]['model'] ?? null;
    }

    /**
     * @param string $prefix
     * @param string $modelName
     * @return string|string[]
     */
    public static function getAttributeByPrefixAndModelName(string $prefix, string $modelName)
    {
        $attrPrefix = config('laravel-crypt-model.model_new_attribute_prefix');
        $prefix = str_replace($attrPrefix,'',$prefix);
        return (str_replace('_','',str_replace($modelName,'',$prefix)));
    }

    /**
     * @param string $hashedPrefixedAttributeValue
     * @return mixed
     * @throws Exceptions\AesEncryptionException
     * @throws ModelNotFoundForPrefix
     */
    public static function findModel(string $hashedPrefixedAttributeValue)
    {
        $attribute_prefix = config('laravel-crypt-model.model_new_attribute_prefix');
        $length = strpos($hashedPrefixedAttributeValue,$attribute_prefix);
        $prefix = substr($hashedPrefixedAttributeValue,0,$length);
        try {
            $model = PrefixedAttributes::$registeredModels[$prefix]['model'];
        }catch (ErrorException $exception){
            LaravelCryptLogger::makeExceptionLog($exception);
            throw ModelNotFoundForPrefix::make($prefix);
        }catch (ModelNotFoundForPrefix $exception){
            LaravelCryptLogger::makeExceptionLog($exception);
            throw ModelNotFoundForPrefix::make($prefix);
        }
        return $model::findByPrefixedAttribute($hashedPrefixedAttributeValue);
    }
}
