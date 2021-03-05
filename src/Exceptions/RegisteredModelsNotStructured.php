<?php


namespace LaravelCryptModel\Exceptions;

use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;
use Illuminate\Database\Eloquent\Model;

class RegisteredModelsNotStructured extends Exception implements ProvidesSolution
{
    /**
     * @param Model $model
     * @param string $attribute
     * @return static
     */
    public static function make(Model $model, string $attribute): RegisteredModelsNotStructured
    {
        $class = get_class($model);
        return new static("Could not generate prefixed `{$attribute}` for model `{$class}`");
    }

    public function getSolution(): Solution
    {
       return BaseSolution::create('Register the prefix for the model')
           ->setSolutionDescription('Check the array you want to register as model 
           according to documentations')
           ->setDocumentationLinks([
               'Documentation' => 'https://github.com/ajangi/laravel-crypt-model',
           ]);
    }

}