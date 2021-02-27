<?php

namespace LaravelCryptModel\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use LaravelCryptModel\PrefixedAttributes;

/**
 * Trait HasHashedAttributes
 * @package LaravelCryptModel\Models\Concerns
 */
trait HasHashedPrefixedAttributes
{
    public static function bootHasHashedPrefixedAttributes()
    {
        static::creating(function (Model $model){
            $attribute_prefix = config('laravel-crypt-model.model_new_attribute_prefix');
            $registered_prefixes = static::getModelRegisteredPrefixes();
            foreach ($registered_prefixes as $prefix => $item){
                $attributeName = $attribute_prefix.$prefix;
                $model->{$attributeName} = $model->generatePrefixedHashedAttribute($item);
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
     * @param array $item
     */
    protected function generatePrefixedHashedAttribute(array $item)
    {

    }
}