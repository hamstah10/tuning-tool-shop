
.. include:: ../../../../Includes.txt

.. _Environment-getLanguageKey:

==============================================
Environment::getLanguageKey()
==============================================

\\nn\\t3::Environment()->getLanguageKey();
----------------------------------------------

Die aktuelle Sprache (als Kürzel wie "de") im Frontend holen

.. code-block:: php

	\nn\t3::Environment()->getLanguageKey();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getLanguageKey () {
   	$request = $this->getRequest();
   	if ($request instanceof ServerRequestInterface) {
   		$data = $request->getAttribute('language', null);
   		if ($data) {
   			return $data->getTwoLetterIsoCode();
   		}
   	}
   	return '';
   }
   

