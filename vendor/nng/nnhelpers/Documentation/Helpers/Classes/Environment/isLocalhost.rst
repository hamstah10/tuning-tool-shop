
.. include:: ../../../../Includes.txt

.. _Environment-isLocalhost:

==============================================
Environment::isLocalhost()
==============================================

\\nn\\t3::Environment()->isLocalhost();
----------------------------------------------

Checks whether installation is running on local server

.. code-block:: php

	\nn\t3::Environment()->isLocalhost()

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function isLocalhost () {
   	$localhost = ['127.0.0.1', '::1'];
   	return in_array($_SERVER['REMOTE_ADDR'], $localhost);
   }
   

