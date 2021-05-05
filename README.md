# User-Activity-Monitoring

A non-invasive, lightweight WordPress plugin adding user activity monitoring support. User-Activity-Monitoring is a plug-and-play plugin with no required configuration.

## Table of contents

- [Get a specific user activity status from it's ID]()
- [Example: Display the currently viewed user (`author.php`) activity status]()
- [Get an array of all users currently online]()
- [Example: Display all users currently online]()
- [Example: Display the total count of users currently online]()
- [Get an array of all users recently offline]()
- [Example: Display all users recently offline]()
- [While in a template-part]()
- [Bugs and feature requests]()
- [Copyright and license]()
- [Installation]()

## Get a specific user activity status from it's ID
```php
<?php 

/**
 * Get a specific user activity status from it's ID.
 *
 * @since 1.0.0
 *
 * @param Integer $user_id The user ID.
 *
 * @return Bool True for online.
 */
$user_activity_monitoring->is_user_currently_online( $user_id );
```

### Example
Display the currently viewed user (`author.php`) activity status.

```php
<?php 

if ( get_queried_object() instanceof \WP_User && is_author() ) {

  if ( $user_activity_monitoring->is_user_currently_online( get_queried_object_id() ) ) {

    echo '🟢 Online';

  } else {

    echo '🔴 Offline';

  };

};
```

## Get an array of all users currently online
```php
<?php 

/**
 * Get an array of all users currently online.
 *
 * @since 1.0.0
 *
 * @return Array An array of currently online users ID.
 */
$user_activity_monitoring->get_currently_online_nusers();
```

### Example
Display all users currently online.

```php
<?php 

$currently_online_nusers = $user_activity_monitoring->get_currently_online_nusers(); 

echo '<ul>';

foreach( $currently_online_nusers as $user_id ) {

  if ( get_current_user_id() !== $user_id ) {

    echo '<li><a href="' . esc_url( get_author_posts_url( $user_id ) ) . '">
      @' . get_userdata( $user_id )->display_name . '🟢 Online
    </a></li>';

  };

};

echo '</ul>';
```

### Example
Display the total count of users currently online.

```php
<?php 

$currently_online_nusers_count = $user_activity_monitoring->get_currently_online_nusers(); 

echo sizeof( $currently_online_nusers_count );
```

## Get an array of all users recently offline
```php
<?php 

/**
 * Get an array of all users recently offline.
 *
 * @since 1.0.0
 *
 * @return Array An array of recently offline users ID.
 */
$user_activity_monitoring->get_recently_offline_nusers();
```

### Example
Display all users recently offline.

```php
<?php 

$recently_offline_nusers = $user_activity_monitoring->get_recently_offline_nusers(); 

echo '<ul>';

foreach( $recently_offline_nusers as $user_id ) {

  if ( get_current_user_id() !== $user_id ) {

    echo '<li><a href="' . esc_url( get_author_posts_url( $user_id ) ) . '">
      @' . get_userdata( $user_id )->display_name . '🔴 Offline
    </a></li>';

  };

};

echo '</ul>';
```

## While in a template-part
To be abble to use a method from a template-part, it is required to pass the class variable to the template-part. You can pass additional arguments to a template-part via the `$args` parameter. Latest version `1.0.1`.

|Parameters|Description|
|-|-|
|`$args`|(array) (Optional) Additional arguments passed to the template-part. Default value: `array()`|

- Source @ https://developer.wordpress.org/reference/functions/get_template_part/

```php
<?php

get_template_part( 'templates', 'my-awesome-template-part', 
    array( 
        'user_activity_monitoring' => $user_activity_monitoring, 
    ) 
);
```

Then you can call the argument from the template-part via `$args['my_argument_handle']`.

```php
<?php

$user_activity_monitoring = $args['user_activity_monitoring'];

// ...
```

## Bugs and feature requests

A problem ? An idea ? Please [Open a new issue on GitHub](https://github.com/amarinediary/User-Activity-Monitoring/issues/new) or [Ask a question on Wordpress User-Activity-Monitoring support](https://wordpress.org/support/plugin/forminator/#new-topic-0).

## Copyright and license

Released under [CC0 1.0 Universal (CC0 1.0) Public Domain Dedication](https://github.com/amarinediary/User-Activity-Monitoring/blob/main/LICENSE).

## Installation

If you have a copy of the plugin as a zip file, you can manually upload it and install it through the Plugins admin screen.

1. Navigate to Plugins `→` Add New.
2. Click the Upload Plugin button at the top of the screen.
3. [Download the plugin as a zip file](https://github.com/amarinediary/User-Activity-Monitoring/archive/refs/heads/main.zip), Select it from your local filesystem.
4. Click the Install Now button.
5. When installation is complete, you’ll see “Plugin installed successfully.” Click the Activate Plugin button at the bottom of the page.
