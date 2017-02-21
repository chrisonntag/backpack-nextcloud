<?php
 namespace OCA\Backpack\Controller;

 use Exception;

 use OCP\IRequest;
 use OCP\AppFramework\Http;
 use OCP\AppFramework\Http\DataResponse;
 use OCP\AppFramework\Controller;

 use OCA\Backpack\Db\Link;
 use OCA\Backpack\Db\LinkMapper;

 class LinkController extends Controller {

     private $mapper;
     private $userId;

     public function __construct($AppName, IRequest $request, LinkMapper $mapper, $UserId){
         parent::__construct($AppName, $request);
         $this->mapper = $mapper;
         $this->userId = $UserId;
     }

     /**
      * @NoAdminRequired
      */
     public function index() {
         return new DataResponse($this->mapper->findAll($this->userId));
     }

     /**
      * @NoAdminRequired
      *
      * @param int $id
      */
     public function show($id) {
         try {
             return new DataResponse($this->mapper->find($id, $this->userId));
         } catch(Exception $e) {
             return new DataResponse([], Http::STATUS_NOT_FOUND);
         }
     }

     /**
      * @NoAdminRequired
      *
      * @param string $title
      * @param string $link
      */
     public function create($title, $_link) {
         $link = new Link();
         $link->setTitle($title);
         $link->setLink($_link);
         $link->setUserId($this->userId);
         return new DataResponse($this->mapper->insert($link));
     }

     /**
      * @NoAdminRequired
      *
      * @param int $id
      * @param string $title
      * @param string $link
      */
     public function update($id, $title, $_link) {
         try {
             $link = $this->mapper->find($id, $this->userId);
         } catch(Exception $e) {
             return new DataResponse([], Http::STATUS_NOT_FOUND);
         }
         $link->setTitle($title);
         $link->setLink($_link);
         return new DataResponse($this->mapper->update($link));
     }

     /**
      * @NoAdminRequired
      *
      * @param int $id
      */
     public function destroy($id) {
         try {
             $link = $this->mapper->find($id, $this->userId);
         } catch(Exception $e) {
             return new DataResponse([], Http::STATUS_NOT_FOUND);
         }
         $this->mapper->delete($link);
         return new DataResponse($link);
     }

 }