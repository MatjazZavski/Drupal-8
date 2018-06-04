# Onboarding base setup

The main purpose of Onboarding base files is the basic setup of Drupal page as instructed in initial steps of Onboarding project. 
With this the developers can quickly skip unnecessary preparations and start with the task at hand.

## This project includes:
* **Drupal installation with all modules and dependencies via composer.**
* **Database**
* **Image files**
* **Steps from Onboarding project specifications**  
  * Content types and all the fields:
      * Company
      * Location
      * Event
  * Views:
      * Company (Company page, Company events block).
      * Location (Locations page, Locations events block).
      * Event (Events page, Events location block, Events organizer block).
  * Content for content types:
      * Company (9)
      * Location (9)
      * Event (11)
    
## Prerequisites

Beside the usual tools that are used for setting up Drupal projects, you will need:
* Composer - it is a composer based project.

## Basic Setup
Project is located on [https://bitbucket.org/agiledrop/onboarding-base](https://bitbucket.org/agiledrop/onboarding-base)
1. Clone repository: 
    
        git clone git@bitbucket.org:agiledrop/onboarding-base.git
    

2. Install and setup Drupal modules and dependencies by running:
    
        composer install
    
    
3. Create and import database. Database folder is located in root folder in **Database.zip** file.

4. Copy Images. Images are located in Files.zip file located in root folder. Extract the files to **[web/sites/default/files](/web/sites/default/files)**

5. Open settings.php file in [web/sites/default/settings.php](web/sites/default/settings.php) and uncomment last 5 lines to enable and load local development override configuration.
    
        if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
          include $app_root . '/' . $site_path . '/settings.local.php';
        }
        $config_directories['sync'] = '../config/sync';
        $settings['install_profile'] = 'standard';
    
6. Set database info in settings.local.php by copying [/web/sites/example.settings.local.php](/web/sites/example.settings.local.php) to [/web/sites/default/settings.local.php](/web/sites/default/settings.local.php) and add at the end of this newly created file following code (add your own database connection info).
    
        /**
         * Database settings:
         *
         * The $databases array specifies the database connection or
         * connections that Drupal may use.  Drupal is able to connect
         * to multiple databases, including multiple types of databases,
         * during the same request.
         */
          $databases['default']['default'] = array(
            'database' => 'databasename',
            'username' => 'sqlusername',
            'password' => 'sqlpassword',
            'host'     => 'localhost',
            'driver'   => 'mysql',
            'port'     => 3306,
            'prefix'   => '',
          );
        
        /**
         * Hash salt settings.
         */
        $settings['hash_salt'] = '14d6f3f6643d629e1c37c0c2f1eb58df28a27466fdc09851fe15e04b66a4534g';
        
    
## This is it, you are ready to start with your task.