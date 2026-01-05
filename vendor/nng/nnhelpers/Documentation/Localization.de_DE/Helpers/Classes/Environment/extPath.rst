
.. include:: ../../../../Includes.txt

.. _Environment-extPath:

==============================================
Environment::extPath()
==============================================

\\nn\\t3::Environment()->extPath(``$extName = ''``);
----------------------------------------------

absoluten Pfad zu einer Extension holen
z.B. ``/var/www/website/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extPath('extname');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function extPath ( $extName = '' ) {
   	return ExtensionManagementUtility::extPath( $extName );
   }
   

