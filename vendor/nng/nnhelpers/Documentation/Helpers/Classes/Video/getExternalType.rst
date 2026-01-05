
.. include:: ../../../../Includes.txt

.. _Video-getExternalType:

==============================================
Video::getExternalType()
==============================================

\\nn\\t3::Video()->getExternalType(``$url = NULL``);
----------------------------------------------

Returns an array with information about the streaming platform and code for embedding a video.

.. code-block:: php

	\nn\t3::Video()->getExternalType( 'https://www.youtube.com/watch/abTAgsdjA' );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getExternalType( $url = null )
   {
   	foreach (self::$VIDEO_PREGS as $type=>$pregs) {
   		foreach ($pregs as $cnt => $arr) {
   			foreach ($arr as $index => $preg) {
   				if (preg_match($preg, $url, $match)) {
   					return [
   						'type'		=> $type,
   						'videoId'	=> $match[$index],
   						'embedUrl'	=> $this->getEmbedUrl($type, $match[$index]),
   						'watchUrl'	=> $this->getWatchUrl($type, $match[$index]),
   					];
   				}
   			}
   		}
   	}
   	return [];
   }
   

