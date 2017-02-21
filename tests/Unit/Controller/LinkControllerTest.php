<?php
namespace OCA\Backpack\Tests\Unit\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\Backpack\Service\NotFoundException;


class LinkControllerTest extends PHPUnit_Framework_TestCase {

    protected $controller;
    protected $service;
    protected $userId = 'chris';
    protected $request;

    public function setUp() {
        $this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
        $this->service = $this->getMockBuilder('OCA\Backpack\Service\LinkService')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = new LinkController(
            'backpack', $this->request, $this->service, $this->userId
        );
    }

    public function testUpdate() {
        $link = 'just check if this value is returned correctly';
        $this->service->expects($this->once())
            ->method('update')
            ->with($this->equalTo(3),
                    $this->equalTo('title'),
                    $this->equalTo('link'),
                   $this->equalTo($this->userId))
            ->will($this->returnValue($link));

        $result = $this->controller->update(3, 'title', 'link');

        $this->assertEquals($link, $result->getData());
    }


    public function testUpdateNotFound() {
        // test the correct status code if no link is found
        $this->service->expects($this->once())
            ->method('update')
            ->will($this->throwException(new NotFoundException()));

        $result = $this->controller->update(3, 'title', 'link');

        $this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
    }

}