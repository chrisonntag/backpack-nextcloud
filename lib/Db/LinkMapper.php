<?php
namespace OCA\Backpack\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class LinkMapper extends Mapper {

    public function __construct(IDb $db) {
        parent::__construct($db, 'backpack_links', '\OCA\Backpack\Db\Link');
    }

    public function find($id, $userId) {
        $sql = 'SELECT * FROM *PREFIX*backpack_links WHERE id = ? AND user_id = ?';
        return $this->findEntity($sql, [$id, $userId]);
    }

    public function findAll($userId) {
        $sql = 'SELECT * FROM *PREFIX*backpack_links WHERE user_id = ?';
        return $this->findEntities($sql, [$userId]);
    }

}