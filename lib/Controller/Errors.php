<?php
namespace OCA\Backpack\Controller;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCA\Backpack\Service\LinkDoesNotExistException;
/**
 * Class Errors
 *
 * @package OCA\Notes\Controller
 */
trait Errors {
    /**
     * @param $callback
     * @return DataResponse
     */
    protected function respond ($callback) {
        try {
            return new DataResponse($callback());
        } catch(LinkDoesNotExistException $ex) {
            return new DataResponse([], Http::STATUS_NOT_FOUND);
        }
    }
}