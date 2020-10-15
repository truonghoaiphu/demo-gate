<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-02
 * Time: 20:25
 */

return [
    'extra'                                         => 'chuc-nang-bo-sung',
    'admin/extra'                                   => 'quan-tri/chuc-nang-bo-sung',
    'errors/{code}'                                 => 'ma-loi/{code}',
    'admin/errors/{code}'                           => 'quan-tri/ma-loi/{code}',

    'me'                                            => 'ca-nhan-toi',
    'me/settings'                                   => 'ca-nhan-toi/thiet-lap',
    'me/account'                                    => 'ca-nhan-toi/tai-khoan',

    'auth'                                          => 'xac-thuc',
    'auth/login'                                    => 'xac-thuc/dang-nhap',
    'auth/logout'                                   => 'xac-thuc/dang-xuat',
    'auth/unverified-email'                         => 'xac-thuc/chua-kich-hoat-email',
    'auth/verify-email'                             => 'xac-thuc/kich-hoat-email',
    'auth/verify-email/{id}/{verification_code}'    => 'xac-thuc/kich-hoat-email/{id}/{verification_code}',

    'old-system/account-passport/login'             => 'he-thong-cu/chung-thuc-tai-khoan/dang-nhap',
    'old-system/account-passport/callback'          => 'he-thong-cu/chung-thuc-tai-khoan/kiem-tra',
    'old-system/account-passport/logout'            => 'he-thong-cu/chung-thuc-tai-khoan/dang-xuat',

    'admin'                                         => 'quan-tri',
    'admin/old-system'                              => 'quan-tri/he-thong-cu',
    'admin/passport-clients'                        => 'quan-tri/ho-chieu-may-khach',
    'admin/app-options'                             => 'quan-tri/thiet-lap',
    'admin/app-options/{id}'                        => 'quan-tri/thiet-lap/{id}',
    'admin/app-options/{id}/edit'                   => 'quan-tri/thiet-lap/{id}/chinh-sua',
    'admin/extensions'                              => 'quan-tri/tien-ich-mo-rong',
    'admin/extensions/{name}'                       => 'quan-tri/tien-ich-mo-rong/{name}',
    'admin/extensions/{name}/edit'                  => 'quan-tri/tien-ich-mo-rong/{name}/chinh-sua',
    'admin/ui-lang/php'                             => 'quan-tri/ngon-ngu-cho-giao-dien/tap-tin-php',
    'admin/ui-lang/email'                           => 'quan-tri/ngon-ngu-cho-giao-dien/mau-email',
];