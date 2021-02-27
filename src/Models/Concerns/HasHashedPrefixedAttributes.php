<?php

namespace LaravelCryptModel\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use LaravelCryptModel\Encode\LaravelCryptEncoder;
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
                $attributeName = $prefix.$attribute_prefix;
                $attribute = PrefixedAttributes::getAttributeByPrefixAndModelName($attributeName, $item['model_name']);
                $attributeValue = $model->{$attribute};
                $model->{$attributeName} = $model->generatePrefixedHashedAttribute($attributeName, $attributeValue);
                $model->model_name = $item['model_name'];
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
     */
    protected function generatePrefixedHashedAttribute($attributeName, $attributeValue): string
    {
        return $attributeName.(new LaravelCryptEncoder())->encrypt($attributeValue);
    }

    public function findByPrefixedAttribute(string $prefix,string $value): ?Model
    {
        $attribute_prefix = config('laravel-crypt-model.model_new_attribute_prefix');
        $encodedValue = substr($value,strlen($attribute_prefix)+strpos($value,$attribute_prefix));
        $atrValue = (new LaravelCryptEncoder())->decrypt($encodedValue);
        return $this->firstWhere(PrefixedAttributes::getAttributeByPrefixAndModelName($prefix,$this->model_name), $atrValue);
    }
}