
.. include:: ../../../../Includes.txt

.. _ExtConfTemplateHelper-textfield:

==============================================
ExtConfTemplateHelper::textfield()
==============================================

\\nn\\t3::ExtConfTemplateHelper()->textfield(``$conf = []``);
----------------------------------------------

Mehrzeiliges Textfeld / Textarea im Extension Manager Konfigurator zeigen.
Diese Zeile in ``ext_conf_template.txt`` der eigenen Extension nutzen:

.. code-block:: php

	# cat=basic; type=user[Nng\Nnhelpers\Helpers\ExtConfTemplateHelper->textfield]; label=Mein Label
	meinFeldName =

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function textfield( $conf = [] ) {
   	return "<textarea style=\"min-height:100px\" name=\"{$conf['fieldName']}\" class=\"form-control\">{$conf['fieldValue']}</textarea>";
   }
   

