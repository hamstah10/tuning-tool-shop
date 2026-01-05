
.. include:: ../../../../Includes.txt

.. _Environment-extLoaded:

==============================================
Environment::extLoaded()
==============================================

\\nn\\t3::Environment()->extLoaded(``$extName = ''``);
----------------------------------------------

Prüfen, ob Extension geladen ist.

.. code-block:: php

	\nn\t3::Environment()->extLoaded('news');

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function extLoaded ( $extName = '' ) {
   	return ExtensionManagementUtility::isLoaded( $extName );
   }
   

