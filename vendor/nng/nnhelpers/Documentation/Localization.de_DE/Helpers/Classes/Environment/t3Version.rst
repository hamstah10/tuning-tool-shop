
.. include:: ../../../../Includes.txt

.. _Environment-t3Version:

==============================================
Environment::t3Version()
==============================================

\\nn\\t3::Environment()->t3Version();
----------------------------------------------

Die Version von Typo3 holen, als Ganzzahl, z.b "8"
Alias zu ``\nn\t3::t3Version()``

.. code-block:: php

	\nn\t3::Environment()->t3Version();
	
	if (\nn\t3::t3Version() >= 8) {
	    // nur für >= Typo3 8 LTS
	}

| ``@return int``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function t3Version () {
   	return \nn\t3::t3Version();
   }
   

