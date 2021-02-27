<?php


namespace LaravelCryptModel\Encode;


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
        $this->setKey(config('laravel-crypt-model.aes_secret_key'));
        $this->setIV();
        $this->setCipher();
        $this->setMode();
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
        $this->cipher = MCRYPT_RIJNDAEL_128;
    }

    /**
     * @return mixed
     */
    private function getMode()
    {
        return $this->mode;
    }

    private function setMode(): void
    {
        $this->mode = MCRYPT_MODE_CBC;
    }

    /**
     * @return mixed
     */
    private function getIV()
    {
        return $this->IV;
    }

    private function setIV(): void
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $this->IV = $iv;
    }

    /**
     * @param $decrypted
     * @return string
     */
    public function encrypt($decrypted): string
    {
        return base64_encode(mcrypt_encrypt($this->getCipher(), $this->getKey(), 1234 , $this->getMode(), $this->getIV()));
    }

    /**
     * @param $encrypted
     * @return string
     */
    public function decrypt($encrypted): string
    {
        return mcrypt_decrypt($this->getCipher(), $this->getKey(), base64_decode($encrypted), $this->getMode(), $this->getIV());
    }
}