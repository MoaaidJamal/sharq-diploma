<?php

return [
    'api_key' => '-Ho9yht3TuSRHDgX-q8Tmg',
    'api_secret' => 'P7p8nW1adDZfC8ch7PvOD5bPuhj62gisv4JE',
    'base_url' => 'https://api.zoom.us/v2/',
    'token_life' => 60 * 60 * 24 * 7, // In seconds, default 1 week
    'authentication_method' => 'jwt', // Only jwt compatible at present but will add OAuth2
    'max_api_calls_per_request' => '5' // how many times can we hit the api to return results for an all() request
];
