
.. include:: ../../../../Includes.txt

.. _Environment-t3Version:

==============================================
Environment::t3Version()
==============================================

\\nn\\t3::Environment()->t3Version();
----------------------------------------------

Get the version of Typo3, as an integer, e.g. "8"
Alias to ``\nn\t3::t3Version()``

.. code-block:: php

	\nn\t3::Environment()->t3Version();
	
	if (\nn\t3::t3Version() >= 8) {
	    // only for >= Typo3 8 LTS
	}

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function t3Version () {
   	return \nn\t3::t3Version();
   }
   

