<?php


namespace LaravelCryptModel\Exceptions;


use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;

class AesEncryptionException extends Exception implements ProvidesSolution
{
    /**
     * @return static
     */
    public static function make(): AesEncryptionException
    {
        return new static("Aes encryption error! Check documentation and config file");
    }
    public function getSolution(): Solution
    {
        return BaseSolution::create('Check documentation!')
            ->setSolutionDescription('Check the documentation and config file!')
            ->setDocumentationLinks([
                'Documentation' => 'https://github.com/ajangi/laravel-crypt-model',
            ]);
    }
}
