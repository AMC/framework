<?php

// Settings
require_once 'config/database.php';

// Database Drivers
require_once 'core/database_drivers/iDBDriver.php';
require_once 'core/database_drivers/MongoDriver.php';


// Core files
require_once 'core/ReflectiveObject.php';
require_once 'core/Controller.php';
require_once 'core/ControllerFactory.php';
require_once 'core/Database.php';
require_once 'core/Model.php';
require_once 'core/ModelFactory.php';
require_once 'core/DataType.php';
require_once 'core/Component.php';
require_once 'core/Response.php';

// Components
require_once 'components/Date.php';
require_once 'components/Decimal.php';
require_once 'components/Email.php';
require_once 'components/Number.php';
require_once 'components/Phone.php';
require_once 'components/TextArea.php';
require_once 'components/String.php';
require_once 'components/Tag.php';
require_once 'components/Text.php';

// Models
require_once 'models/Blog.php';
require_once 'models/Comment.php';

// Controllers
