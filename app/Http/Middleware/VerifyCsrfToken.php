<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        "admin/*",
        "upload_add",
        "addqiniu",
        "upload_manage",
        "upload_del",
        "forumAdd",
        "wap/upload_add_qiniu",
        "wap/upload_add_qiniu_video",
        "api/*",
    ];
}
