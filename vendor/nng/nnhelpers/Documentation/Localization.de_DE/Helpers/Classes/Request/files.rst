
.. include:: ../../../../Includes.txt

.. _Request-files:

==============================================
Request::files()
==============================================

\\nn\\t3::Request()->files(``$path = NULL, $forceArray = false``);
----------------------------------------------

File-Uploads aus ``$_FILES`` holen und normalisieren.

Normalisiert folgende File-Upload-Varianten.
Enfernt leere Datei-Uploads aus dem Array.

.. code-block:: php

	<input name="image" type="file" />
	<input name="image[key]" type="file" />
	<input name="images[]" type="file" multiple="1" />
	<input name="images[key][]" type="file" multiple="1" />

Beispiele:
ALLE Datei-Infos aus ``$_FILES``holen.

.. code-block:: php

	\nn\t3::Request()->files();
	\nn\t3::Request()->files( true ); // Array erzwingen

Datei-Infos aus ``tx_nnfesubmit_nnfesubmit[...]`` holen.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit');
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit', true);    // Array erzwingen

Nur Dateien aus ``tx_nnfesubmit_nnfesubmit[fal_media]`` holen.

.. code-block:: php

	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media' );
	\nn\t3::Request()->files('tx_nnfesubmit_nnfesubmit.fal_media', true ); // Array erzwingen

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
   

