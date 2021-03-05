<?php


namespace LaravelCryptModel\Encode;


use LaravelCryptModel\Exceptions\AesEncryptionException;
use LaravelCryptModel\Logger\LaravelCryptLogger;

class LaravelCryptEncoder
{
    protected  $key;
    protected  $cipher;
    protected  $mode;
    protected  $IV;

    /**
     * LaravelCryptEncoder constructor.
     */
    public function __construct()
    {
        $this->setCipher();
        $this->setKey(config('laravel-crypt-model.aes_secret_key'));
        $this->setIV(config('laravel-crypt-model.aes_secret_iv'));
    }

    /**
     * @return mixed
     */
    private function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    private function setKey($key): void
    {
        $key = hash('sha256', $key);
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    private function getCipher()
    {
        return $this->cipher;
    }

    private function setCipher(): void
    {
        $this->cipher = 'AES-256-CBC';
    }

    /**
     * @return mixed
     */
    private function getIV()
    {
        return $this->IV;
    }

    private function setIV($iv): void
    {
        $iv = substr(hash('sha256', $iv), 0, 16);
        $this->IV = $iv;
    }

    /**
     * @param $decrypted
     * @return string
     * @throws AesEncryptionException
     */
    public function encrypt($decrypted): string
    {
        try {
            $result =  openssl_encrypt($decrypted, $this->getCipher(), $this->getKey() , 0, $this->getIV(), $tag);
        }catch (AesEncryptionException $exception){
            LaravelCryptLogger::makeExceptionLog($exception);
            throw AesEncryptionException::make();
        }
        if ($result === false){
            throw AesEncryptionException::make();
        }
        return $result;
    }

    /**
     * @param $encrypted
     * @return string
     * @throws AesEncryptionException
     */
    public function decrypt($encrypted): string
    {
        $tag = "";
        try {
            $result =  openssl_decrypt($encrypted, $this->getCipher(), $this->getKey(), $options=0, $this->getIV(), $tag);
        }catch (AesEncryptionException $exception){
            LaravelCryptLogger::makeExceptionLog($exception);
            throw AesEncryptionException::make();
        }
        if ($result === false){
            throw AesEncryptionException::make();
        }
        return $result;
    }
}
