.. include:: ../../Includes.txt

.. _configuration_extmanager:

============
Extension Manager Configuration
============

Configurations in the Extension Manager
-------------------------------

Use the backend module "Settings -> Extension Configuration" to modify the following settings: 

.. figure:: ../../Images/ext-conf.jpg
   :class: with-shadow
   :alt: Extension Manager
   :width: 100%

basic.apiKeys
""""""""""""""
.. container:: table-row

   Property
        basic.apiKeys
   Data type
        text
   Description
        List of global api users that can access the endpoint.
        One user per line. Username and ApiKey separated by a single colon (:)
        
        All usernames will work, except for the default "examplefeUserName".

        ::
          user1:theApiKeyOfUser1
          user2:theApiKeyOfUser2

   Default
        examplefeUserName:exampleApiKey

basic.maxSessionLifetime
""""""""""""""
.. container:: table-row

   Property
        basic.maxSessionLifetime
   Data type
        number
   Description
        Defines how long an inactive user stays logged in (seconds).

   Default
        3600

basic.disableDefaultEndpoints
""""""""""""""
.. container:: table-row

   Property
        basic.disableDefaultEndpoints
   Data type
        boolean
   Description
        Disables (removes) all endpoints shipped by default with nnrestapi. 
        If disabled, you will need to implement your own endpoints for authenticating 
        users and checking their status.

   Default
        FALSE

basic.disablePreCheck
""""""""""""""
.. container:: table-row

   Property
        basic.disablePreCheck
   Data type
        boolean
   Description
        Disables all warnings and checks during installation.

   Default
        FALSE

basic.disableDonationWarning
""""""""""""""
.. container:: table-row

   Property
        basic.disableDonationWarning
   Data type
        boolean
   Description
        Disables donation information. 
        
        .. warning::
        
           Please make sure you have actually donated before checking this box. 
           Otherwise, ancient voodoo magic will be unleashed upon your codebase, 
           causing random semicolons to disappear and your CSS to mysteriously 
           break at 3am. You have been warned. 🐔

   Default
        FALSE

basic.fileEncryptionKey
""""""""""""""
.. container:: table-row

   Property
        basic.fileEncryptionKey
   Data type
        text
   Description
        Key for file encryption.

   Default
        (empty)

---------

Logging Settings
-------------------------------

The following settings control the logging behavior of the extension. 
See :ref:`Logging <logging>` for more details.

.. figure:: ../../Images/ext-manager-logging.jpg
   :class: with-shadow
   :alt: Extension Manager Logging Settings
   :width: 100%

logging.loggingEnabled
""""""""""""""
.. container:: table-row

   Property
        logging.loggingEnabled
   Data type
        boolean
   Description
        Enable custom logging. Allows logging of requests to the API based on 
        the ``@Api\Log()`` annotation.

   Default
        FALSE

logging.loggingMode
""""""""""""""
.. container:: table-row

   Property
        logging.loggingMode
   Data type
        options
   Description
        Decides what to log based on the ``@Api\Log()`` annotation:

        * ``all``: Log all requests, except those with ``@Api\Log(false)``
        * ``explicit``: Only log requests that have ``@Api\Log()`` or ``@Api\Log(true)``
        * ``force``: Log all requests, ignoring any ``@Api\Log()`` annotations

   Default
        all

logging.errorLoggingEnabled
""""""""""""""
.. container:: table-row

   Property
        logging.errorLoggingEnabled
   Data type
        boolean
   Description
        Enable error logging. Logs errors to the API.

   Default
        FALSE

logging.errorLoggingMode
""""""""""""""
.. container:: table-row

   Property
        logging.errorLoggingMode
   Data type
        options
   Description
        Decides what type of errors to log:

        * ``all``: Log all errors
        * ``exception``: Only log critical errors like PHP exceptions
        * ``api``: Only log errors called by ``\nn\rest::ApiError()``

   Default
        all

logging.loggingAutoClear
""""""""""""""
.. container:: table-row

   Property
        logging.loggingAutoClear
   Data type
        number
   Description
        Remove log entries older than X days. The logs will be deleted by a 
        scheduler task - make sure you include this task in your crontab.

   Default
        7

logging.loggingTempDuration
""""""""""""""
.. container:: table-row

   Property
        logging.loggingTempDuration
   Data type
        number
   Description
        Duration of temporary logging in minutes. How long the logging will 
        stay active when enabled in the RestApi backend module.

   Default
        30

logging.logfiles
""""""""""""""
.. container:: table-row

   Property
        logging.logfiles
   Data type
        boolean
   Description
        Save logs in logfile. Will keep a backup of the logfiles as CSV in 
        ``/var/log/`` after deleting them from the database.

   Default
        FALSE

logging.logIpMode
""""""""""""""
.. container:: table-row

   Property
        logging.logIpMode
   Data type
        options
   Description
        How to anonymize IP addresses in logs. Important to protect privacy of the users:

        * ``none``: Do not save IP addresses
        * ``anonymized``: Save anonymized IP (last octets removed)
        * ``hashed``: Save hashed & salted IP
        * ``ip``: Save full IP address

   Default
        anonymized

logging.logPayload
""""""""""""""
.. container:: table-row

   Property
        logging.logPayload
   Data type
        boolean
   Description
        Whether to log the payload of the request.

   Default
        TRUE