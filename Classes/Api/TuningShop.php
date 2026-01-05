<?php   
namespace Hamstahstudio\TuningToolShop\Api;

use Nng\Nnrestapi\Annotations as Api;

/**
 * @Api\Endpoint()
 */
class TuningShop extends \Nng\Nnrestapi\Api\AbstractApi {

   /**
    * @Api\Access("public")
    * @return array
    */
   public function getIndexAction()
   {
      return ['great'=>'it works!'];
   }

   public function getRawAction()
   {
      return ['great'=>'it works!'];
   }

   public function getProduktAction()
   {
      return ['great'=>'it works!'];
   }
}