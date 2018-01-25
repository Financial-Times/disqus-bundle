<?php

namespace Inviqa\DisqusBundle\Twig;

use AuthenticationBundle\Security\User\WebUser;
use Twig\Environment;
use Inviqa\DisqusBundle\Disqus\Disqus;
use Inviqa\DisqusBundle\Disqus\RemoteAuthSerializer;

class DisqusExtension extends \Twig_Extension
{
    /**
     * @var RemoteAuthSerializer
     */
    private $remoteAuth;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $forumName;

    public function __construct(RemoteAuthSerializer $remoteAuth, string $publicKey, string $forumName)
    {
        $this->remoteAuth = $remoteAuth;
        $this->publicKey = $publicKey;
        $this->forumName = $forumName;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('inviqa_disqus_get_remote_auth_s3', array($this->remoteAuth, 'remoteAuthForUser')),
            new \Twig_SimpleFunction('inviqa_disqus_public_key', function () { return $this->publicKey; }),
            new \Twig_SimpleFunction('inviqa_disqus_forum_name', function () { return $this->forumName; }),
        );
    }
}
