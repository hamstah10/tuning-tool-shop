
.. include:: ../../../Includes.txt

.. _ExtConfTemplateHelper:

==============================================
ExtConfTemplateHelper
==============================================

\\nn\\t3::ExtConfTemplateHelper()
----------------------------------------------

Extension for the Extension Manager form.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::ExtConfTemplateHelper()->textfield(``$conf = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Show multiline text field / textarea in the Extension Manager configurator.
Use this line in ``ext_conf_template.txt`` of your own extension:

.. code-block:: php

	# cat=basic; type=user[Nng\Nnhelpers\Helpers\ExtConfTemplateHelper->textfield]; label=My label
	myFieldName =

| ``@return string``

| :ref:`➜ Go to source code of ExtConfTemplateHelper::textfield() <ExtConfTemplateHelper-textfield>`

Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. toctree::
   :glob:
   :maxdepth: 1

   *
   !Index
