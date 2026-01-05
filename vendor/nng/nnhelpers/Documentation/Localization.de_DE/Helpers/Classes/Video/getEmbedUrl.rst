
.. include:: ../../../../Includes.txt

.. _Video-getEmbedUrl:

==============================================
Video::getEmbedUrl()
==============================================

\\nn\\t3::Video()->getEmbedUrl(``$type, $videoId = NULL``);
----------------------------------------------

Einbettungs-URL anhand der Streaming-Plattform zurückgeben.
Klassischerweise die URL, die im src-Attribut des <iframe>
verwendet wird.

.. code-block:: php

	\nn\t3::Video()->getEmbedUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getEmbedUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );

Existiert auch als ViewHelper:

.. code-block:: php

	{my.videourl->nnt3:video.embedUrl()}

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getEmbedUrl ($type, $videoId = null)
   {
   	if (!$videoId && strpos($type, 'http') !== false) {
   		$infos = $this->isExternal( $type );
   		return $infos['embedUrl'];
   	}
   	switch ($type) {
   		case 'youtube':
   			return 'https://www.youtube-nocookie.com/embed/'.$videoId;
   		case 'vimeo':
   			return 'https://player.vimeo.com/video/'.$videoId;
   	}
   }
   

