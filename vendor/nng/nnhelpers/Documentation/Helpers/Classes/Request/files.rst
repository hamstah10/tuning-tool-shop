
.. include:: ../../../../Includes.txt

.. _Request-files:

==============================================
Request::files()
==============================================

\\nn\\t3::Request()->files(``$path = NULL, $forceArray = false``);
----------------------------------------------

Get and normalize file uploads from ``$_FILES``.

Normalizes the following file upload variants.
Removes empty file uploads from the array.

.. code-block:: php

	
	
	
	

Examples:
 ``Get``ALL file info from ``$_FILES``.

.. code-block:: php

	\nn\t3::Request()->files();
	\nn\t3::Request()->files( true ); // Force array

Get file info from ``tx_nnfesubmit_nnfesubmit[...]``.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true); // Force array

Only get files from ``tx_nnfesubmit_nnfesubmit[fal_media]``.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Force array

| ``@return array``

Source Code
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

   
   public function files( $path = null, $forceArray = false )
   {
   	if (!$_FILES) return [];
   	if ($path === true) {
   		$path = false;
   		$forceArray = true;
   	}
   	$fileInfosByKey = [];
   	// 'tx_nnfesubmit_nnfesubmit' => ['name' => ..., 'size' => ...]
   	foreach ($_FILES as $varName => $aspects) {
   		if (!($fileInfosByKey[$varName] ?? false)) {
   			$fileInfosByKey[$varName] = [];
   		}
   		foreach ($aspects as $aspectKey => $vars) {
   			// $aspectKey ist IMMER 'name' || 'tmp_name' || 'size' || 'error'
   			if (!is_array($vars)) {
   				// <input type="file" name="image" />
   				if ($forceArray) {
   					$fileInfosByKey[$varName][0][$aspectKey] = $vars;
   				} else {
   					$fileInfosByKey[$varName][$aspectKey] = $vars;
   				}
   			} else {
   				foreach ($vars as $varKey => $varValue) {
   					// <input type="file" name="images[]" multiple="1" />
   					if (is_numeric($varKey)) {
   						$fileInfosByKey[$varName][$varKey][$aspectKey] = $varValue;
   					}
   					if (!is_numeric($varKey)) {
   						if (!is_array($varValue)) {
   							// <input type="file" name="image[key]" />
   							if ($forceArray) {
   								$fileInfosByKey[$varName][$varKey][0][$aspectKey] = $varValue;
   							} else {
   								$fileInfosByKey[$varName][$varKey][$aspectKey] = $varValue;
   							}
   						} else {
   							// <input type="file" name="images[key][]" multiple="1" />
   							foreach ($varValue as $n=>$v) {
   								$fileInfosByKey[$varName][$varKey][$n][$aspectKey] = $v;
   							}
   						}
   					}
   				}
   			}
   		}
   	}
   	// Leere Uploads entfernen
   	foreach ($fileInfosByKey as $k=>$v) {
   		if (isset($v['error']) && $v['error'] == UPLOAD_ERR_NO_FILE) {
   			unset($fileInfosByKey[$k]);
   		}
   		if (is_array($v)) {
   			foreach ($v as $k1=>$v1) {
   				if (isset($v1['error']) && $v1['error'] == UPLOAD_ERR_NO_FILE) {
   					unset($fileInfosByKey[$k][$k1]);
   				}
   				if (is_array($v1)) {
   					foreach ($v1 as $k2=>$v2) {
   						if (isset($v2['error']) && $v2['error'] == UPLOAD_ERR_NO_FILE) {
   							unset($fileInfosByKey[$k][$k1][$k2]);
   						}
   					}
   				}
   			}
   		}
   	}
   	if (!$path) return $fileInfosByKey;
   	return \nn\t3::Settings()->getFromPath( $path, $fileInfosByKey );
   }
   

