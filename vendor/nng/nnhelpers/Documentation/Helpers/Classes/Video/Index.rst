
.. include:: ../../../Includes.txt

.. _Video:

==============================================
Video
==============================================

\\nn\\t3::Video()
----------------------------------------------

Everything that is important and helpful on the subject of videos.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Video()->getEmbedUrl(``$type, $videoId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Return the embed URL based on the streaming platform.
Classically, the URL that is used in the src attribute of the <iframe>
is used.

.. code-block:: php

	\nn\t3::Video()->getEmbedUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getEmbedUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );

Also exists as ViewHelper:

.. code-block:: php

	{my.videourl->nnt3:video.embedUrl()}

| ``@return string``

| :ref:`➜ Go to source code of Video::getEmbedUrl() <Video-getEmbedUrl>`

\\nn\\t3::Video()->getExternalType(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Returns an array with information about the streaming platform and code for embedding a video.

.. code-block:: php

	\nn\t3::Video()->getExternalType( 'https://www.youtube.com/watch/abTAgsdjA' );

| ``@return array``

| :ref:`➜ Go to source code of Video::getExternalType() <Video-getExternalType>`

\\nn\\t3::Video()->getWatchUrl(``$type, $videoId = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Link URL to the video on the external platform
e.g. to display an external link to the video

.. code-block:: php

	\nn\t3::Video()->getWatchUrl( $fileReference );
	\nn\t3::Video()->getWatchUrl( 'youtube', 'nShlloNgM2E' );
	\nn\t3::Video()->getWatchUrl( 'https://www.youtube.com/watch?v=wu55ZG97zeI&feature=youtu.be' );
	
	// => https://www.youtube-nocookie.com/watch?v=kV8v2GKC8WA

| ``@return string``

| :ref:`➜ Go to source code of Video::getWatchUrl() <Video-getWatchUrl>`

\\nn\\t3::Video()->isExternal(``$url = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Checks whether the URL is an external video on YouTube or Vimeo.
Returns an array with data for embedding.

.. code-block:: php

	\nn\t3::Video()->isExternal( 'https://www.youtube.com/...' );

| ``@return array``

| :ref:`➜ Go to source code of Video::isExternal() <Video-isExternal>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
