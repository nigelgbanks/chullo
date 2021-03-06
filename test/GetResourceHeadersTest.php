<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Islandora\Chullo\Chullo;

class GetResourceHeadersTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers  Islandora\Fedora\Chullo::getResourceHeaders
     * @uses    GuzzleHttp\Client
     */
    public function testReturnsHeadersOn200() {
        $mock = new MockHandler([
            new Response(200, ['Status: 200 OK', 'ETag: "bbdd92e395800153a686773f773bcad80a51f47b"', 'Last-Modified: Wed, 28 May 2014 18:31:36 GMT', 'Last-Modified: Thu, 20 Nov 2014 15:44:32 GMT', 'Link: <http://www.w3.org/ns/ldp#Resource>;rel="type"', 'Link: <http://www.w3.org/ns/ldp#Container>;rel="type"', 'Link: <http://www.w3.org/ns/ldp#BasicContainer>;rel="type"', 'Accept-Patch: application/sparql-update', 'Accept-Post: text/turtle,text/rdf+n3,text/n3,application/rdf+xml,application/n-triples,multipart/form-data,application/sparql-update', 'Allow: MOVE,COPY,DELETE,POST,HEAD,GET,PUT,PATCH,OPTIONS']),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler, 'base_uri' => 'http://localhost:8080/fcrepo/rest']);
        $client = new Chullo($guzzle);

        $result = $client->getResourceHeaders("");
        $this->assertSame((array)$result, [['Status: 200 OK'], ['ETag: "bbdd92e395800153a686773f773bcad80a51f47b"'], ['Last-Modified: Wed, 28 May 2014 18:31:36 GMT'], ['Last-Modified: Thu, 20 Nov 2014 15:44:32 GMT'], ['Link: <http://www.w3.org/ns/ldp#Resource>;rel="type"'], ['Link: <http://www.w3.org/ns/ldp#Container>;rel="type"'], ['Link: <http://www.w3.org/ns/ldp#BasicContainer>;rel="type"'], ['Accept-Patch: application/sparql-update'], ['Accept-Post: text/turtle,text/rdf+n3,text/n3,application/rdf+xml,application/n-triples,multipart/form-data,application/sparql-update'], ['Allow: MOVE,COPY,DELETE,POST,HEAD,GET,PUT,PATCH,OPTIONS']]);
    }

    /**
     * @covers            Islandora\Fedora\Chullo::getResourceHeaders
     * @uses              GuzzleHttp\Client
     * @expectedException GuzzleHttp\Exception\ClientException
     */
    public function testThrowsExceptionOn404() {
        $mock = new MockHandler([
            new Response(404),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler, 'base_uri' => 'http://localhost:8080/fcrepo/rest']);
        $client = new Chullo($guzzle);

        $result = $client->getResourceHeaders("");
    }
}
