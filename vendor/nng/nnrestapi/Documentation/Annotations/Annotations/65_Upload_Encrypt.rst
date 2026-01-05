.. include:: ../../Includes.txt

.. _annotations_upload_encrypt:

============
@Api\\Upload\\Encrypt
============

Encrypt uploaded files on-the-fly
---------

.. warning::

   This annotation is **experimental** and not fully implemented yet. 
   The API may change in future versions. Use at your own risk.

The ``@Api\Upload\Encrypt()`` annotation allows encrypting uploaded files on-the-fly before 
they are stored on the server. This can be useful for sensitive documents that need to be 
protected at rest.

**The syntax is:**

.. code-block:: php

   @Api\Upload\Encrypt("default")
   @Api\Upload\Encrypt("config[keyname]")


The value ``"default"`` refers to the default encryption configuration defined in TypoScript.
You can also use ``"config[keyname]"`` to reference a custom configuration.

**Full example:**

.. code-block:: php

   <?php

   namespace My\Extension\Api;

   use Nng\Nnrestapi\Annotations as Api;
   use Nng\Nnrestapi\Api\AbstractApi;

   /**
    * @Api\Endpoint()
    */
   class Document extends AbstractApi
   {
      /**
       * Upload and encrypt a sensitive document.
       *
       * @Api\Upload("1:/secure-uploads/")
       * @Api\Upload\Encrypt("default")
       * @Api\Access("fe_users")
       * @return array
       */
      public function postSecureAction() 
      {
         $files = $this->request->getUploadedFiles();
         return ['uploaded' => count($files)];
      }
   }


How it works
---------

When a file is uploaded with encryption enabled:

1. The file is renamed to include a ``.enc`` marker (e.g., ``filename.enc.jpg``)
2. The file content is encrypted using AES encryption with an initialization vector (IV)
3. The IV is stored at the beginning of the encrypted file
4. The original file is replaced with the encrypted version

Encrypted files can only be decrypted using the same encryption key.

Configuration
---------

The encryption is configured via TypoScript. The default configuration is:

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.fileUploadEncrypt {
      default {
         # Class with methods for encrypting / decrypting files
         encryptionClass = Nng\Nnrestapi\Helper\UploadEncryptHelper

         # Number of 16-byte blocks to read/write at a time (default: 255)
         fileEncryptionBlocks = 255

         # Cipher algorithm (AES-128-CBC or AES-256-CBC)
         cipher = AES-128-CBC
      }
   }

Available options
~~~~~~~~~~~~

``encryptionClass``
   The PHP class responsible for encryption/decryption. You can create your own class 
   by extending ``Nng\Nnrestapi\Helper\AbstractUploadEncryptHelper``.

``cipher``
   The encryption algorithm to use:

   * ``AES-128-CBC``: 128-bit AES encryption (requires 16-byte key)
   * ``AES-256-CBC``: 256-bit AES encryption (requires 32-byte key)

``fileEncryptionBlocks``
   Number of 16-byte blocks to process at a time during encryption. Default is 255.
   Higher values use more memory but may be faster for large files.

Encryption key
~~~~~~~~~~~~

The encryption key is set in the Extension Manager under ``basic.fileEncryptionKey``.

* If no key is set, a random key will be **auto-generated** on first use
* For ``AES-128-CBC``, the key must be 16 bytes (base64 encoded)
* For ``AES-256-CBC``, the key must be 32 bytes (base64 encoded)

.. important::

   **Keep your encryption key safe!** If you lose the key, you will not be able to decrypt 
   the uploaded files. Consider backing up the key in a secure location.

Custom encryption configurations
---------

You can define multiple encryption configurations in TypoScript:

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.fileUploadEncrypt {
      default {
         encryptionClass = Nng\Nnrestapi\Helper\UploadEncryptHelper
         cipher = AES-128-CBC
      }
      highSecurity {
         encryptionClass = Nng\Nnrestapi\Helper\UploadEncryptHelper
         cipher = AES-256-CBC
      }
   }

Then reference them in your annotation:

.. code-block:: php

   @Api\Upload\Encrypt("config[highSecurity]")


Custom encryption class
---------

You can create your own encryption class by extending ``AbstractUploadEncryptHelper``.
This allows you to implement custom encryption algorithms or integrate with external 
encryption services.

**Step 1: Create your custom encryption class**

.. code-block:: php

   <?php
   namespace My\Extension\Helper;

   use Nng\Nnrestapi\Helper\AbstractUploadEncryptHelper;
   use TYPO3\CMS\Core\Http\UploadedFile;

   class MyEncryptHelper extends AbstractUploadEncryptHelper
   {
      /**
       * Rename the file before it is moved to the target folder.
       * Use this to add markers like `.enc` to the filename.
       *
       * @param string $filename Original filename
       * @param string $targetPath Target folder path
       * @param UploadedFile $file The uploaded file object
       * @return string The new filename
       */
      public function getFilename($filename, $targetPath, $file) 
      {
         $suffix = pathinfo($filename, PATHINFO_EXTENSION);
         return uniqid() . '.encrypted.' . $suffix;
      }

      /**
       * Encrypt the file after it has been moved to the target folder.
       *
       * @param string $filename Path to the file (relative to site root)
       * @param string $targetPath Target folder path
       * @param UploadedFile $fileObj The uploaded file object
       * @return void
       */
      public function encrypt($filename, $targetPath, $fileObj) 
      {
         $absPath = \nn\t3::File()->absPath($filename);
         $content = file_get_contents($absPath);
         
         // Your encryption logic here
         $encrypted = $this->myEncryptionMethod($content);
         
         file_put_contents($absPath, $encrypted);
      }

      /**
       * Decrypt a file. Writes the decrypted content to a temporary destination file.
       * This method is called when serving encrypted files to the user.
       *
       * Note: Uses file streams to support large files without memory issues.
       *
       * @param string $sourcePath Path to the encrypted file
       * @param string $destPath Path where decrypted file should be written (temp file)
       * @return bool
       */
      public function decrypt($sourcePath, $destPath) 
      {
         $fpIn = $this->openSourceFile($sourcePath);
         $fpOut = $this->openDestFile($destPath);
         
         // Read, decrypt and write in chunks for large file support
         while (!feof($fpIn)) {
            $chunk = fread($fpIn, 8192);
            $decrypted = $this->myDecryptionMethod($chunk);
            fwrite($fpOut, $decrypted);
         }
         
         fclose($fpIn);
         fclose($fpOut);
         
         return true;
      }

      private function myEncryptionMethod($data) 
      {
         // Implement your encryption
         return $data;
      }

      private function myDecryptionMethod($data) 
      {
         // Implement your decryption
         return $data;
      }
   }

**Step 2: Register your class in TypoScript**

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.fileUploadEncrypt {
      myCustomEncryption {
         encryptionClass = My\Extension\Helper\MyEncryptHelper
         
         # You can pass additional configuration options
         # They will be available in $this->configuration
         myCustomOption = someValue
      }
   }

**Step 3: Use the annotation in your endpoint**

.. code-block:: php

   <?php
   namespace My\Extension\Api;

   use Nng\Nnrestapi\Annotations as Api;
   use Nng\Nnrestapi\Api\AbstractApi;

   /**
    * @Api\Endpoint()
    */
   class SecureDocument extends AbstractApi
   {
      /**
       * Upload a file with custom encryption.
       *
       * @Api\Upload("1:/secure-documents/")
       * @Api\Upload\Encrypt("config[myCustomEncryption]")
       * @Api\Access("fe_users")
       * @return array
       */
      public function postUploadAction() 
      {
         $files = $this->request->getUploadedFiles();
         return ['success' => true, 'files' => count($files)];
      }
   }

Accessing configuration in your class
~~~~~~~~~~~~

Any options you define in TypoScript are available in your class via ``$this->configuration``:

.. code-block:: php

   public function encrypt($filename, $targetPath, $fileObj) 
   {
      // Access your custom TypoScript options
      $myOption = $this->configuration['myCustomOption'] ?? 'default';
      
      // Use it in your encryption logic
      // ...
   }

