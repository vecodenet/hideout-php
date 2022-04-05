hideout-php
===========

PHP SDK for Vecode Hideout

This is a slim library for interacting with a Vecode Hideout server, so you must have a working instance in order to use this library.

To get started you will need to configure the server and add a client so that you get a client token, please refer to its respective documentation if you need more details.

Also remember to always connect to Vecode Hideout instances using `https`.

### Installing

First require `vecode/hideout-php` with Composer.

### Basic usage

Now get an instance of `Hideout` with the `newInstance` method and set the server location and client token:

```php
use Hideout\Hideout;

$server = 'https://hideout.my-server.com';
$token = 'xxxxx.yyyyyyyyyyyyy';

$hideout = Hideout::newInstance()
  ->setServer($server)
  ->setToken($token);
```

Once you have your `Hideout` object you may start interacting with the server.

### Generating keys

In addition to the client token, you will require a secret key (or several ones) to store and retrieve secrets on the server, so there's a handy endpoint for getting a valid key.

Is as simple as calling the `generate` method:

```php
use Hideout\Hideout;

$server = 'https://hideout.my-server.com';
$token = 'xxxxx.yyyyyyyyyyyyy';

$hideout = Hideout::newInstance()
  ->setServer($server)
  ->setToken($token);

$key = $hideout->generate();
```

Once you got the key it must be saved in a safe place. For example you can set it as an environment variable so that you have it at hand later.

**Never store it in a public directory that can be accessed from the web.**

### Storing secrets

With your key you can create secrets, by using the `store` method and passing the `key` and secret `data`:

```php
use Hideout\Hideout;

$server = 'https://hideout.my-server.com';
$token = 'xxxxx.yyyyyyyyyyyyy';
$key = getenv('my_secret_key');

$hideout = Hideout::newInstance()
  ->setServer($server)
  ->setToken($token);

$data = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae atque officiis natus voluptatum debitis sunt.';
$entry = $hideout->store($key, $data); // $entry would be 'xxxxxyyyyzzz' for example
```

In this case you will receive the `entry` identifier of the secret once it is stored on the server. With this identifier you may retrieve it later.

### Retrieveing secrets

To get the secrets back just call the `retrieve` method, this time you must pass the `key` and the `entry` identifier:

```php
use Hideout\Hideout;

$server = 'https://hideout.my-server.com';
$token = 'xxxxx.yyyyyyyyyyyyy';
$key = getenv('my_secret_key');

$hideout = Hideout::newInstance()
  ->setServer($server)
  ->setToken($token);

$entry = 'xxxxxyyyyzzz';
$data = $hideout->retrieve($key, $entry); // $data would be 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae atque officiis natus voluptatum debitis sunt.'
```

Then you will receive the original data.

### Deleting secrets

There's also the option to delete any secret by calling the `delete` method with the `entry` identifier:

```php
use Hideout\Hideout;

$server = 'https://hideout.my-server.com';
$token = 'xxxxx.yyyyyyyyyyyyy';

$hideout = Hideout::newInstance()
  ->setServer($server)
  ->setToken($token);

$entry = 'xxxxxyyyyzzz';
$hideout->delete($entry); // Just returns TRUE or FALSE
```

### Troubleshooting

The most common problem is with `https`. This library uses `biohzrdmx/curly-php` and it requires a properly configured server to work. Please [refer to its documentation](https://github.com/biohzrdmx/curly-php) to get more details.

Otherwise please open an issue and we will gladly help you.

### Licensing

This software is released under the MIT license.

Copyright © 2022 biohzrdmx

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

### Credits

**Lead coder:** biohzrdmx [github.com/biohzrdmx](http://github.com/biohzrdmx)
