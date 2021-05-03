# WPC-User-Activity-Monitoring
WPC-User-Activity-Monitoring. A non-invasive, lightweight WordPress plugin adding user activity monitoring support. Latest version 1.0.0.

## Get a specific user activity status from it's ID.
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
$wpc_user_activity_monitoring->is_user_currently_online( $user_id );
```

### Example
Display the currently viewed user (`author.php`) activity status.

```php
<?php 

if ( get_queried_object() instanceof \WP_User && is_author() ) {

  if ( $wpc_user_activity_monitoring->is_user_currently_online( get_queried_object_id() ) ) {

    echo '🟢 Online';

  } else {

    echo '🔴 Offline';

  };

};
```

## Get an array of all users currently online.
```php
<?php 

/**
 * Get an array of all users currently online.
 *
 * @since 1.0.0
 *
 * @return Array An array of currently online users ID.
 */
$wpc_user_activity_monitoring->get_currently_online_nusers();
```

### Example
Display all users currently online.

```php
<?php 

$currently_online_nusers = $wpc_user_activity_monitoring->get_currently_online_nusers(); 

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

$currently_online_nusers_count = $wpc_user_activity_monitoring->get_currently_online_nusers(); 

echo sizeof( $currently_online_nusers_count );
```

## Get an array of all users recently offline.
```php
<?php 

/**
 * Get an array of all users recently offline.
 *
 * @since 1.0.0
 *
 * @return Array An array of recently offline users ID.
 */
$wpc_user_activity_monitoring->get_recently_offline_nusers();
```

### Example
Display all users recently offline.

```php
<?php 

$recently_offline_nusers = $wpc_user_activity_monitoring->get_recently_offline_nusers(); 

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
        'wpc_user_activity_monitoring' => $wpc_user_activity_monitoring, 
    ) 
);
```

Then you can call the argument from the template-part via `$args['my_argument_handle']`.

```php
<?php

$wpc_user_activity_monitoring = $args['wpc_user_activity_monitoring'];

// ...
```
