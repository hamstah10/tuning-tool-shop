
.. include:: ../../../../Includes.txt

.. _Page-hasSubpages:

==============================================
Page::hasSubpages()
==============================================

\\nn\\t3::Page()->hasSubpages(``$pid = NULL``);
----------------------------------------------

Checks whether a page has submenus

.. code-block:: php

	\nn\t3::Page()->hasSubpages();

| ``@return boolean``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function hasSubpages( $pid = null ) {
   	return count( $this->getSubpages($pid) ) > 0;
   }
   

