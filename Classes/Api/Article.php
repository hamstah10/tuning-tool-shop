<?php   
namespace Hamstahstudio\TuningToolShop\Api;

use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * @Api\Endpoint()
 */
class Article extends AbstractApi
{
   /**
    * @Api\Access("public")
    * @return array
    */
   public function getIndexAction()
   {
     return ['great'=>'it works!'];
   }
   
   /**
    * @Api\Route("/article/route/{uid}")
    * @Api\Access("public")
    * 
    * @return array
    */
   public function getRouteAction( $uid = null )
   {
      $args = $this->request->getArguments();
      return ['message'=>"Hello, {$uid}!"];
   }
}

