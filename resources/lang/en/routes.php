<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-02
 * Time: 20:25
 */

return [
    'extra'                                         => 'extra',
    'admin/extra'                                   => 'admin/extra',
    'errors/{code}'                                 => 'errors/{code}',
    'admin/errors/{code}'                           => 'admin/errors/{code}',

    'me'                                            => 'me',
    'me/settings'                                   => 'me/settings',
    'me/account'                                    => 'me/account',

    'auth'                                          => 'auth',
    'auth/login'                                    => 'auth/login',
    'auth/logout'                                   => 'auth/logout',
    'auth/unverified-email'                         => 'auth/unverified-email',
    'auth/verify-email'                             => 'auth/verify-email',
    'auth/verify-email/{id}/{verification_code}'    => 'auth/verify-email/{id}/{verification_code}',

    'old-system/account-passport/login'             => 'old-system/account-passport/login',
    'old-system/account-passport/callback'          => 'old-system/account-passport/callback',
    'old-system/account-passport/logout'            => 'old-system/account-passport/logout',

    'admin'                                         => 'admin',
    'admin/old-system'                              => 'admin/old-system',
    'admin/passport-clients'                        => 'admin/passport-clients',
    'admin/app-options'                             => 'admin/app-options',
    'admin/app-options/{id}'                        => 'admin/app-options/{id}',
    'admin/app-options/{id}/edit'                   => 'admin/app-options/{id}/edit',
    'admin/extensions'                              => 'admin/extensions',
    'admin/extensions/{name}'                       => 'admin/extensions/{name}',
    'admin/extensions/{name}/edit'                  => 'admin/extensions/{name}/edit',
    'admin/ui-lang/php'                             => 'admin/ui-lang/php',
    'admin/ui-lang/email'                           => 'admin/ui-lang/email',
];