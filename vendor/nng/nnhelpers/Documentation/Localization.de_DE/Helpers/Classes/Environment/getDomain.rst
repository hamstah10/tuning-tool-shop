
.. include:: ../../../../Includes.txt

.. _Environment-getDomain:

==============================================
Environment::getDomain()
==============================================

\\nn\\t3::Environment()->getDomain();
----------------------------------------------

Die Domain holen z.B. www.webseite.de

.. code-block:: php

	\nn\t3::Environment()->getDomain();

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getDomain () {
   	$domain = preg_replace('/(http)([s]*)(:)\/\//i', '', $this->getBaseURL());
   	return rtrim($domain, '/');
   }
   

