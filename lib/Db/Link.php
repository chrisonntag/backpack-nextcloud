<?php
namespace OCA\Backpack\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Link extends Entity implements JsonSerializable {

    protected $title;
    protected $link;
    protected $userId;

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link
        ];
    }
}
