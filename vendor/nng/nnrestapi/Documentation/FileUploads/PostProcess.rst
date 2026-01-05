.. include:: ../Includes.txt

.. _upload_postprocess:

============
Post-processing uploads
============

Process uploaded files on-the-fly
---------

You can define post-processing operations that are executed after a file has been uploaded.
This is useful for:

* Randomizing filenames for security
* Resizing images on-the-fly
* Converting image formats
* Compressing images

The ``postProcess`` configuration is defined in TypoScript under your file upload configuration:

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.fileUploads {
      myconfig {
         defaultStoragePath = 1:/uploads/
         
         postProcess {
            10 {
               userFunc = Nng\Nnrestapi\Helper\UploadPostProcessHelper::randomizeFilename
            }
            20 {
               userFunc = Nng\Nnrestapi\Helper\UploadPostProcessHelper::imageMaxWidth
               maxWidth = 3000
               filetype = jpg
               quality = 70
            }
         }
      }
   }

Post-processors are executed in order of their numeric keys (10, 20, 30, etc.).

---------
Built-in post-processors
---------

The extension ships with two built-in post-processors:

randomizeFilename
~~~~~~~~~~~~

Renames the uploaded file to a random, unique filename. This is useful for security 
(hiding original filenames) and preventing filename conflicts.

.. code-block:: typoscript

   postProcess {
      10 {
         userFunc = Nng\Nnrestapi\Helper\UploadPostProcessHelper::randomizeFilename
      }
   }

The filename will be converted to a format like: ``1734567890123abc456def.jpg``

imageMaxWidth
~~~~~~~~~~~~

Resizes images to a maximum width while maintaining aspect ratio. Also allows converting 
to a different format and setting compression quality. Requires **ImageMagick** to be installed.

.. code-block:: typoscript

   postProcess {
      20 {
         userFunc = Nng\Nnrestapi\Helper\UploadPostProcessHelper::imageMaxWidth
         
         # Maximum width in pixels (required)
         maxWidth = 3000
         
         # Convert to this format (optional, e.g., jpg, png, webp)
         filetype = jpg
         
         # JPEG compression quality 0-100 (optional, default: 80)
         quality = 70
      }
   }

Features:

* Automatically corrects image orientation (EXIF)
* Strips metadata for smaller file size
* Only resizes if image is larger than maxWidth
* Skips non-image files automatically

---------
Custom post-processors
---------

You can create your own post-processor by defining a static method:

.. code-block:: php

   <?php
   namespace My\Extension\Helper;

   use TYPO3\CMS\Core\Http\UploadedFile;

   class MyUploadPostProcessor
   {
      /**
       * @param string &$targetFileName Path to the uploaded file (pass by reference!)
       * @param string $targetPath Target folder path
       * @param array $processingConfig Configuration from TypoScript
       * @param UploadedFile $fileObj The uploaded file object
       */
      public static function myProcessor(&$targetFileName, $targetPath, $processingConfig, $fileObj)
      {
         // Access your TypoScript configuration
         $myOption = $processingConfig['myOption'] ?? 'default';
         
         // Do something with the file
         // ...
         
         // If you rename/move the file, update $targetFileName!
         // $targetFileName = $newPath;
      }
   }

Then use it in TypoScript:

.. code-block:: typoscript

   postProcess {
      30 {
         userFunc = My\Extension\Helper\MyUploadPostProcessor::myProcessor
         myOption = someValue
      }
   }

.. important::

   The ``$targetFileName`` parameter is passed **by reference**. If your post-processor 
   renames or moves the file, you must update this variable to the new path!

---------
Full example
---------

Here's a complete example with multiple post-processors:

.. code-block:: typoscript

   plugin.tx_nnrestapi.settings.fileUploads {
      gallery {
         defaultStoragePath = 1:/gallery/
         
         postProcess {
            # First: randomize the filename
            10 {
               userFunc = Nng\Nnrestapi\Helper\UploadPostProcessHelper::randomizeFilename
            }
            
            # Then: resize large images
            20 {
               userFunc = Nng\Nnrestapi\Helper\UploadPostProcessHelper::imageMaxWidth
               maxWidth = 2000
               filetype = jpg
               quality = 85
            }
         }
      }
   }

Use it in your endpoint:

.. code-block:: php

   /**
    * @Api\Upload("config[gallery]")
    * @Api\Access("fe_users")
    */
   public function postImageAction()
   {
      $files = $this->request->getUploadedFiles();
      return ['uploaded' => count($files)];
   }

