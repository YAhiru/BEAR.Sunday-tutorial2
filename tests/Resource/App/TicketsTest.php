<?php
declare(strict_types=1);
namespace Yahiru\Ticket\Resource\App;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use PHPUnit\Framework\TestCase;

final class TicketsTest extends TestCase
{
    /** @var ResourceInterface */
    private $resource;

    protected function setUp() : void
    {
        $this->resource = (new AppInjector('Yahiru\Ticket', 'test-app'))->getInstance(ResourceInterface::class);
    }

    public function testOnPost()
    {
        $ro = $this->resource->post('app://self/tickets', [
            'title' => 'title1',
            'status' => 'status1',
            'description' => 'description1',
            'assignee' => 'assignee1',
        ]);
        $this->assertSame(201, $ro->code);
        $this->assertStringContainsString('/ticket?id=', $ro->headers['Location']);

        return $ro;
    }

    /**
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $ro = $this->resource->get('app://self' . $location);
        $this->assertSame('title1', $ro->body['title']);
        $this->assertSame('description1', $ro->body['description']);
        $this->assertSame('assignee1', $ro->body['assignee']);
    }
}
