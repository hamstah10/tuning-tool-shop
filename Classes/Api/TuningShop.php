<?php   
namespace Hamstahstudio\TuningToolShop\Api;

use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * @Api\Endpoint()
 */
class TuningShop extends AbstractApi
{
   
   /**
    * @Api\Route("/tuningshop")
    * @Api\Access("public")
    * 
    * @return array
    */
   public function getIndexAction()
   {
     return ['welcome'=>'TuningShop API is working!'];
   }

   /**
    * @Api\Route("/tuningshop/raw/{uid}")
   * @Api\Access("public")
   * @Api\Localize()
   * 
   * @param int $uid
   * @return array
   */
   public function getRawAction( int $uid = null )
   {
      // Get raw data from table tt_content and include FAL-relations
      $data = \nn\t3::Content()->get( $uid, true );
      return $data;
   }

   /**
    * @Api\Route("/tuningshop/produkt/{name}")
    * @Api\Access("public")
    * 
    * @return array
    */
   public function getProduktAction( $name = null )
   {
      $args = $this->request->getArguments();
      return ['message'=>"Hello, {$name}!"];
   }
}

