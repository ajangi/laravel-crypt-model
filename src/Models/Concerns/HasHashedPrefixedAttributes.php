<?php

namespace LaravelCryptModel\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use LaravelCryptModel\Encode\LaravelCryptEncoder;
use LaravelCryptModel\Exceptions\AesEncryptionException;
use LaravelCryptModel\PrefixedAttributes;

/**
 * Trait HasHashedAttributes
 * @package LaravelCryptModel\Models\Concerns
 */
trait HasHashedPrefixedAttributes
{
    public static $model_name;

    public static function bootHasHashedPrefixedAttributes()
    {
        static::retrieved(function (Model $model){
            $attribute_prefix = config('laravel-crypt-model.model_new_attribute_prefix');
            $registered_prefixes = static::getModelRegisteredPrefixes();
            foreach ($registered_prefixes as $prefix => $item){
                $attributeName = $prefix.$attribute_prefix;
                $attribute = PrefixedAttributes::getAttributeByPrefixAndModelName($attributeName, $item['model_name']);
                $attributeValue = $model->{$attribute};
                $model->{$attributeName} = $model->generatePrefixedHashedAttribute($attributeName, $attributeValue);
                static::$model_name = $item['model_name'];
            }
        });
    }

    /**
     * @return array
     */
    public static function getModelRegisteredPrefixes(): array
    {
        return PrefixedAttributes::getAllRegisteredPrefixesForModel(self::class);
    }

    /**
     * @param $attributeName
     * @param $attributeValue
     * @return string
     * @throws AesEncryptionException
     */
    protected function generatePrefixedHashedAttribute($attributeName, $attributeValue): string
    {
        return $attributeName.(new LaravelCryptEncoder())->encrypt($attributeValue);
    }

    /**
     * @param string $value
     * @return Model|null
     * @throws AesEncryptionException
     */
    public static function findByPrefixedAttribute(string $value): ?Model
    {
        $attribute_prefix = config('laravel-crypt-model.model_new_attribute_prefix');
        $length = strlen($attribute_prefix)+strpos($value,$attribute_prefix);
        $encodedValue = substr($value,$length);
        $prefix = substr($value,0,$length);
        $atrValue = (new LaravelCryptEncoder())->decrypt($encodedValue);
        return static::firstWhere(PrefixedAttributes::getAttributeByPrefixAndModelName($prefix, static::getModelName()), $atrValue);
    }

    /**
     * @return mixed|string
     */
    private static function getModelName(): string
    {
        $registered_prefixes = static::getModelRegisteredPrefixes();
        foreach ($registered_prefixes as $prefix => $item){
            return $item['model_name'];
        }
        return '';
    }
}
