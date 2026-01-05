
.. include:: ../../../../Includes.txt

.. _Environment-extRelPath:

==============================================
Environment::extRelPath()
==============================================

\\nn\\t3::Environment()->extRelPath(``$extName = ''``);
----------------------------------------------

relativen Pfad (vom aktuellen Script aus) zu einer Extension holen
z.B. ``../typo3conf/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extRelPath('extname');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function extRelPath ( $extName = '' ) {
   	return PathUtility::getRelativePathTo( $this->extPath($extName) );
   }
   

