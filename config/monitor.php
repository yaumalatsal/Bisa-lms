<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Monitor API token
    |--------------------------------------------------------------------------
    |
    | Shared secret an external monitor (e.g. a status console) presents on
    | every request to /api/monitor/*, either as `Authorization: Bearer <token>`
    | or as the `X-Monitor-Token` header. Compared in constant time.
    |
    | Left unset, the monitor routes refuse every request with a clear
    | "monitoring_disabled" response rather than silently accepting anything —
    | an unconfigured token must never mean "no auth required".
    |
    */
    'token' => env('MONITOR_API_TOKEN'),

];
