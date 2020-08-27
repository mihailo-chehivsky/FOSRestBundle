<?php

/*
 * This file is part of the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Controller\UserValueResolver;

$defaultFirewall = [];
if (method_exists(Security::class, 'getUser') && !class_exists(UserValueResolver::class)) {
    $defaultFirewall['logout_on_user_change'] = true;
}

$container->loadFromExtension('security', [
    'encoders' => ['Symfony\Component\Security\Core\User\User' => 'plaintext'],
    'providers' => [
        'in_memory' => [
            'memory' => [],
        ],
    ],
    'firewalls' => [
        'default' => array_merge($defaultFirewall, [
            'provider' => 'in_memory',
            'anonymous' => 'lazy',
            'stateless' => true,
            'guard' => [
                'authenticators' => [
                    'api_token_authenticator',
                ],
            ],
        ]),
    ],
    'access_control' => [
        ['path' => '^/api', 'roles' => 'ROLE_API'],
    ],
]);