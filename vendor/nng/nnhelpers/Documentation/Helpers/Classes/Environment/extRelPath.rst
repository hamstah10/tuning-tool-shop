
.. include:: ../../../../Includes.txt

.. _Environment-extRelPath:

==============================================
Environment::extRelPath()
==============================================

\\nn\\t3::Environment()->extRelPath(``$extName = ''``);
----------------------------------------------

Get the relative path (from the current script) to an extension
e.g. ``../typo3conf/ext/nnsite/``

.. code-block:: php

	\nn\t3::Environment()->extRelPath('extname');

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function extRelPath ( $extName = '' ) {
   	return PathUtility::getRelativePathTo( $this->extPath($extName) );
   }
   

