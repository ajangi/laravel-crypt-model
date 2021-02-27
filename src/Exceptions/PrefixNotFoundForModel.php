<?php


namespace LaravelCryptModel\Exceptions;


use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;

class PrefixNotFoundForModel extends Exception implements ProvidesSolution
{
    /**
     * @param string $model
     * @param string $attribute
     * @return static
     */
    public static function make(string $model, string $attribute): PrefixNotFoundForModel
    {
        $class = get_class($model);
        return new static("Could not find prefix for `{$attribute}` attribute for model `{$class}`");
    }

    /**
     * @return Solution
     */
    public function getSolution(): Solution
    {
        return BaseSolution::create('Check registered models!')
            ->setSolutionDescription('Check the array you want to register as model 
           according to documentations')
            ->setDocumentationLinks([
                'Documentation' => 'https://github.com/spatie/laravel-prefixed-ids#registering-models-with-prefixed-ids', // todo : Change it
            ]);
    }
}