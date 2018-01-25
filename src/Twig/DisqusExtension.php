<?php

namespace Inviqa\DisqusBundle\Twig;

use AuthenticationBundle\Security\User\WebUser;
use DisqusBundle\Serializer\UserDataSerializer;

class DisqusExtension extends \Twig_Extension
{
    /**
     * @var UserDataSerializer
     */
    private $serializer;

    public function __construct(UserDataSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('disqus_get_remote_auth_s3', array($this->serializer, 'serialize')),
        );
    }
}
