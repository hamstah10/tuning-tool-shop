
.. include:: ../../../../Includes.txt

.. _Page-getRootline:

==============================================
Page::getRootline()
==============================================

\\nn\\t3::Page()->getRootline(``$pid = NULL``);
----------------------------------------------

Rootline für gegebene PID holen

.. code-block:: php

	\nn\t3::Page()->getRootline();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getRootline( $pid = null )
   {
   	if (!$pid) $pid = $this->getPid();
   	if (!$pid) return [];
   	try {
   		$rootLine = GeneralUtility::makeInstance(RootlineUtility::class, $pid);
   		return $rootLine->get() ?: [];
   	} catch ( \Exception $e ) {
   		return [];
   	}
   }
   

