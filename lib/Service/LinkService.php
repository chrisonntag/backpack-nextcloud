<?php
namespace OCA\Backpack\Service;

use Exception;

use OCP\AppFramework\Db\DoeslinkxistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Backpack\Db\Link;
use OCA\Backpack\Db\LinkMapper;


class LinkService {

    private $mapper;

    public function __construct(LinkMapper $mapper){
        $this->mapper = $mapper;
    }

    public function findAll($userId) {
        return $this->mapper->findAll($userId);
    }

    private function handleException ($e) {
        if ($e instanceof DoeslinkxistException ||
            $e instanceof MultipleObjectsReturnedException) {
            throw new NotFoundException($e->getMessage());
        } else {
            throw $e;
        }
    }

    public function find($id, $userId) {
        try {
            return $this->mapper->find($id, $userId);

        // in order to be able to plug in different storage backends like files
        // for instance it is a good idea to turn storage related exceptions
        // into service related exceptions so controllers and service users
        // have to deal with only one type of exception
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

    public function create($title, $_link, $userId) {
        $link = new Link();
        $link->setTitle($title);
        $link->setLink($_link);
        $link->setUserId($userId);
        return $this->mapper->insert($link);
    }

    public function update($id, $title, $_link, $userId) {
        try {
            $link = $this->mapper->find($id, $userId);
            $link->setTitle($title);
            $link->setLink($_link);
            return $this->mapper->update($link);
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

    public function delete($id, $userId) {
        try {
            $link = $this->mapper->find($id, $userId);
            $this->mapper->delete($link);
            return $link;
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

}