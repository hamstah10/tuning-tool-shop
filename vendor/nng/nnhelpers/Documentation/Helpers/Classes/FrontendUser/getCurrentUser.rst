
.. include:: ../../../../Includes.txt

.. _FrontendUser-getCurrentUser:

==============================================
FrontendUser::getCurrentUser()
==============================================

\\nn\\t3::FrontendUser()->getCurrentUser();
----------------------------------------------

Get array with the data of the current FE user.

.. code-block:: php

	\nn\t3::FrontendUser()->getCurrentUser();

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function getCurrentUser()
   {
   	if (!$this->isLoggedIn()) return [];
   	$user = $this->getFrontendUser();
   	if ($user) {
   		return $user->user ?? [];
   	}
   	// Ohne Frontend könnten wir uns z.B. in einer Middleware befinden. Nach AUTH sind die Daten evtl im Aspect.
   	$context = GeneralUtility::makeInstance(Context::class);
   	$userAspect = $context->getAspect('frontend.user');
   	if (!$userAspect) return [];
   	$usergroupUids = array_column($this->resolveUserGroups( $userAspect->get('groupIds') ), 'uid');
   	// Daten zu Standard-Darstellung normalisieren
   	return [
   		'uid'			=> $userAspect->get('id'),
   		'username'		=> $userAspect->get('username'),
   		'usergroup'		=> join(',', $usergroupUids)
   	] ?? [];
   }
   

