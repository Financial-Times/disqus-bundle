<?php

namespace Inviqa\DisqusBundle\Tests\Integration\Twig;

use Inviqa\DisqusBundle\Twig\DisqusExtension;
use Inviqa\DisqusBundle\Disqus\RemoteAuthSerializer;
use PHPUnit\Framework\TestCase;
use Twig\Loader\ArrayLoader;

class DisqusExtensionTest extends TestCase
{
    public function testExtension()
    {
        $twig = new \Twig_Environment(new ArrayLoader([
            'test.html.twig' => <<<'EOT'
Auth: {{ inviqa_disqus_get_remote_auth_s3('1234', 'daniel', 'daniel@example.com') }}
Forum: {{ inviqa_disqus_forum_name() }}
Public: {{ inviqa_disqus_public_key() }}
EOT
        ]));

        $extension = new DisqusExtension(
            new RemoteAuthSerializer('1234', 1234),
            'public',
            'my_forum'
        );

        $twig->addExtension($extension);

        $result = $twig->render('test.html.twig');

        $this->assertEquals(<<<'EOT'
Auth: eyJpZCI6IjEyMzQiLCJ1c2VybmFtZSI6ImRhbmllbCIsImVtYWlsIjoiZGFuaWVsQGV4YW1wbGUuY29tIn0= 3ec8bf11f4f99437b6c0ee18dd3aaa3636681cf4 1234
Forum: my_forum
Public: public
EOT
        , $result);
    }
}
