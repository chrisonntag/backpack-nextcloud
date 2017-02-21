<?php
namespace OCA\Backpack\Tests\Unit\Controller;

require_once __DIR__ . '/LinkControllerTest.php';

class LinkApiControllerTest extends LinkControllerTest {

    public function setUp() {
        parent::setUp();
        $this->controller = new LinkApiController(
            'backpack', $this->request, $this->service, $this->userId
        );
    }

}