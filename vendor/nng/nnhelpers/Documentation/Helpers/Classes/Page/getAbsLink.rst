
.. include:: ../../../../Includes.txt

.. _Page-getAbsLink:

==============================================
Page::getAbsLink()
==============================================

\\nn\\t3::Page()->getAbsLink(``$pidOrParams = NULL, $params = []``);
----------------------------------------------

Generate an absolute link to a page

.. code-block:: php

	\nn\t3::Page()->getAbsLink( $pid );
	\nn\t3::Page()->getAbsLink( $pid, ['type'=>'232322'] );
	\nn\t3::Page()->getAbsLink( ['type'=>'232322'] );

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getAbsLink( $pidOrParams = null, $params = [] ) {
   	return $this->getLink( $pidOrParams, $params, true );
   }
   

