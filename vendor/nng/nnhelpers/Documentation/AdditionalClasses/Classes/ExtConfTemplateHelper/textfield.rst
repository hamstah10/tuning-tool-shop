
.. include:: ../../../../Includes.txt

.. _ExtConfTemplateHelper-textfield:

==============================================
ExtConfTemplateHelper::textfield()
==============================================

\\nn\\t3::ExtConfTemplateHelper()->textfield(``$conf = []``);
----------------------------------------------

Show multiline text field / textarea in the Extension Manager configurator.
Use this line in ``ext_conf_template.txt`` of your own extension:

.. code-block:: php

	# cat=basic; type=user[Nng\Nnhelpers\Helpers\ExtConfTemplateHelper->textfield]; label=My label
	myFieldName =

| ``@return string``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function textfield( $conf = [] ) {
   	return "<textarea style=\"min-height:100px\" name=\"{$conf['fieldName']}\" class=\"form-control\">{$conf['fieldValue']}</textarea>";
   }
   

