<?php   
namespace Hamstahstudio\TuningToolShop\Api;

use Nng\Nnrestapi\Annotations as Api;

/**
 * @Api\Endpoint()
 */
class Demo extends \Nng\Nnrestapi\Api\AbstractApi {

   /**
    * @Api\Access("public")
    * @return array
    */
   public function getIndexAction()
   {
      return ['great'=>'it works!'];
   }
   /**
    * @Api\Access("public")
    * @return array
    */
   public function getExampleAction(): array
   {
      return ['great'=>'it works!'];
   }

   public function getTestAction()
   {
      return ['great'=>'it works!'];
   }
}