
.. include:: ../../../../Includes.txt

.. _Video-getWatchUrl:

==============================================
Video::getWatchUrl()
==============================================

\\nn\\t3::Video()->getWatchUrl(``$type, $videoId = NULL``);
----------------------------------------------

Link URL to the video on the external platform
e.g. to display an external link to the video

.. code-block:: php

	\nn\t3::Video()->getWatchUrl( $fileReference );
	\nn\t3::Video()->getWatchUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getWatchUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );
	
	// => https://www.youtube-nocookie.com/watch?v=kV8v2GKC8WA

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getWatchUrl ($type, $videoId = null )
   {
   	if (\nn\t3::Obj()->isFileReference($type)) {
   		$type = $type->getOriginalResource()->getPublicUrl();
   	}
   	if (!$videoId && strpos($type, 'http') !== false) {
   		$infos = $this->isExternal( $type );
   		return $infos['watchUrl'];
   	}
   	switch ($type) {
   		case 'youtube':
   			return 'https://www.youtube-nocookie.com/watch?v='.$videoId;
   		case 'vimeo':
   			return 'https://vimeo.com/'.$videoId;
   	}
   }
   

