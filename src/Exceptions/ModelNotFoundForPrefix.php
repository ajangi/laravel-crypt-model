<?php


namespace LaravelCryptModel\Exceptions;


use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;

class ModelNotFoundForPrefix extends Exception implements ProvidesSolution
{
    /**
     * @param string $prefix
     * @return ModelNotFoundForPrefix
     */
    public static function make(string $prefix): ModelNotFoundForPrefix
    {
        return new static("Could not find model for prefix `{$prefix}`");
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
