
.. include:: ../../../../Includes.txt

.. _Flexform-getFlexform:

==============================================
Flexform::getFlexform()
==============================================

\\nn\\t3::Flexform()->getFlexform(``$ttContentUid = NULL``);
----------------------------------------------

Retrieves the flexform of a specific content element as an array

.. code-block:: php

	\nn\t3::Flexform()->getFlexform( 1201 );

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getFlexform( $ttContentUid = null ) {
   	$data = \nn\t3::Content()->get( $ttContentUid );
   	if (!$data) return [];
   	$flexformData = $this->parse($data['pi_flexform']);
   	return $flexformData;
   }
   

