<?php   
namespace Hamstahstudio\TuningToolShop\Api;

use Nng\Nnrestapi\Annotations as Api;

/**
 * @Api\Endpoint()
 */
class Article extends \Nng\Nnrestapi\Api\AbstractApi {

   /**
    * @Api\Access("public")
    * @return array
    */
   public function getIndexAction()
   {
      return ['great'=>'it works!'];
   }

   public function getRouteAction()
   {
      return ['great'=>'it works!'];
   }

   /**
    * @Api\Access("public")
    * @return array
    */
   public function getProduktAction()
   {
      return ['great'=>'it works!'];
   }
}