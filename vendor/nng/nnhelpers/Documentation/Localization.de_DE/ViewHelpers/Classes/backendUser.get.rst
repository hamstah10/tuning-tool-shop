
.. include:: ../../Includes.txt

.. _Nng\Nnhelpers\ViewHelpers\BackendUser\GetViewHelper:

=======================================
backendUser.get
=======================================

Description
---------------------------------------

<nnt3:backendUser.get />
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Frontend-User holen

Gibt ein Array mit den Daten des Backend-Users zurück,
enthält auch die Einstellungen des Users.

.. code-block:: php

	{nnt3:backendUser.get(key:'uc.example')}
	{nnt3:backendUser.get()->f:variable.set(name:'beUser')}

