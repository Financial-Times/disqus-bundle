<?php

namespace Inviqa\DisqusBundle\Disqus;

use AuthenticationBundle\Security\User\WebUser;

class RemoteAuthSerializer
{
    /**
     * @var string
     */
    private $disqusSecretKey;

    /**
     * @var int
     */
    private $timestamp;

    public function __construct(string $disqusSecretKey, int $timestamp = null)
    {
        $this->disqusSecretKey = $disqusSecretKey;
        $this->timestamp = $timestamp ?: time();
    }

    public function remoteAuthForUser($identifier, string $username, string $email): string
    {
        $userData = [
            'id' => $identifier,
            'username' => $username,
            'email' => $email,
        ];

        $message = base64_encode(json_encode($userData));
        $serialized = sprintf(
            '%s %s %s',
            $message,
            $this->dsqHmacSha1($message . ' ' . $this->timestamp, $this->disqusSecretKey),
            $this->timestamp
        );

        return $serialized;
    }

    private function dsqHmacSha1($data, $key): string
    {
        $blockSize = 64;
        $hashFunc = 'sha1';

        if (strlen($key) > $blockSize) {
            $key = pack('H*', $hashFunc($key));
        }

        $key = str_pad($key, $blockSize, chr(0x00));
        $iPad = str_repeat(chr(0x36), $blockSize);
        $oPad = str_repeat(chr(0x5c), $blockSize);
        $hmac = pack(
            'H*', $hashFunc(
                ($key ^ $oPad) . pack(
                    'H*', $hashFunc(
                        ($key ^ $iPad) . $data
                    )
                )
            )
        );

        return bin2hex($hmac);
    }
}
