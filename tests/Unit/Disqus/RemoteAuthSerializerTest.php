<?php

namespace Inviqa\DisqusBundle\Tests\Unit\Disqus;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Inviqa\DisqusBundle\Disqus\RemoteAuthSerializer;

class RemoteAuthSerializerTest extends TestCase
{
    /**
     * @var RemoteAuthSerializer
     */
    private $serializer;

    public function setUp()
    {
        $this->serializer = new RemoteAuthSerializer(
            'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',
            1516870506
        );
    }

    /**
     * @dataProvider provideSerialize
     */
    public function testSerialize($identifier, string $username, string $email, string $expected)
    {
        $result = $this->serializer->remoteAuthForUser($identifier, $username, $email);
        $this->assertEquals($expected, $result);
    }

    public function provideSerialize()
    {
        return [
            [
                1234,
                'Daniel',
                'daniel@example.com',
                'eyJpZCI6MTIzNCwidXNlcm5hbWUiOiJEYW5pZWwiLCJlbWFpbCI6ImRhbmllbEBleGFtcGxlLmNvbSJ9 bd3daea4b21fa0275f77aa827aced179add2283d 1516870506',
            ],
            [
                '3c770578-b6fb-11e6-bdc8-0242ac110004',
                'Daniel',
                'daniel@example.com',
                'eyJpZCI6IjNjNzcwNTc4LWI2ZmItMTFlNi1iZGM4LTAyNDJhYzExMDAwNCIsInVzZXJuYW1lIjoiRGFuaWVsIiwiZW1haWwiOiJkYW5pZWxAZXhhbXBsZS5jb20ifQ== d0b40089f325842c9a64ea83e6729b841924fb53 1516870506',
            ],
            [
                '1cb578ee-a047-4603-83b5-5b908c6639a6',
                'registered@test.com',
                'registered@test.com',
                'eyJpZCI6IjFjYjU3OGVlLWEwNDctNDYwMy04M2I1LTViOTA4YzY2MzlhNiIsInVzZXJuYW1lIjoicmVnaXN0ZXJlZEB0ZXN0LmNvbSIsImVtYWlsIjoicmVnaXN0ZXJlZEB0ZXN0LmNvbSJ9 427c68e3c3b439005ca7db9b6005edecbe4a685c 1516870506',
            ]
        ];
    }
}
