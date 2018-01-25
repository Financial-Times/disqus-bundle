<?php

namespace Inviqa\DisqusBundle\Serializer;

use AuthenticationBundle\Security\User\WebUser;

class UserDataSerializer
{
    private $disqusSecretKey;

    public function __construct(string $disqusSecretKey)
    {
        $this->disqusSecretKey = $disqusSecretKey;
    }

    public function serialize(WebUser $webUser): string
    {
        $userData = [
            'id' => str_replace('-', '', $webUser->revealUser()->id()),
            'username' => $webUser->getUsername(),
            'email' => $webUser->revealUser()->getEmail(),
        ];

        $message = base64_encode(json_encode($userData));

        $timestamp = time();

        $hmac = $this->dsqHmacSha1($message . ' ' . $timestamp, $this->disqusSecretKey);

        $serialized = vsprintf('%s %s %s', [$message, $hmac, $timestamp]);
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
