
.. include:: ../../../../Includes.txt

.. _Http-followRedirect:

==============================================
Http::followRedirect()
==============================================

\\nn\\t3::Http()->followRedirect(``$url``);
----------------------------------------------

Weiterleitungs-Ziel ermitteln

.. code-block:: php

	\nn\t3::Http()->followRedirect( 'https://www.99grad.de/some/redirect' );

| ``@param string $url``
| ``@return void``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function followRedirect( string $url )
   {
   	$ch = curl_init();
   	curl_setopt($ch, CURLOPT_URL, $url);
   	curl_setopt($ch, CURLOPT_HEADER, true);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   	$response = curl_exec($ch);
   	$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
   	curl_close($ch);
   	return $url;
   }
   

