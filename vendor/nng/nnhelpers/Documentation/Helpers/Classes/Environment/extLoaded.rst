
.. include:: ../../../../Includes.txt

.. _Environment-extLoaded:

==============================================
Environment::extLoaded()
==============================================

\\nn\\t3::Environment()->extLoaded(``$extName = ''``);
----------------------------------------------

Check whether extension is loaded.

.. code-block:: php

	\nn\t3::Environment()->extLoaded('news');

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function extLoaded ( $extName = '' ) {
   	return ExtensionManagementUtility::isLoaded( $extName );
   }
   

