<?php

namespace Supabase;

class FunctionsClient {

    /**
     * Initialize Supabase functions client
     * @access public
     * @param $url string Project's Supabase URL
     * @param $headers array Corresponding headers to pass in
     * @return void
     */
    public function __construct(string $url, array $headers)
    {
        $this->url = $url;
        $this->headers = $headers;
    }
}
