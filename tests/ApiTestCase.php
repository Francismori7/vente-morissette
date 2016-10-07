<?php

abstract class ApiTestCase extends TestCase {
    /**
     * Performs a call.
     *
     * @param $method
     * @param $uri
     * @param array $params
     * @param array $headers
     * @return $this
     */
    public function ajax($method, $uri, $params = [], $headers = [])
    {
        $server = $this->transformHeadersToServerVars(array_merge(['Accept' => 'application/json'], $headers));

        $this->call($method, $uri, $params, [], [], $server);

        return $this;
    }
}