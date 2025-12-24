<?php

namespace Hamstahstudio\TuningToolShop\Api;

use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * @Api\Endpoint()
 */
class Demo extends \Nng\Nnrestapi\Api\AbstractApi {

   /**
    * @Api\Access("public")
    * @return array
    */
   public function getExampleAction()
   {
      return ['great'=>'it works!'];
   }
   public function getTestAction()
   {
      return ['great'=>'it works!'];
   }
}