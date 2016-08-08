# NPR One Backend Proxy

A PHP-based server-side proxy for interacting with the [NPR One API](http://dev.npr.org/api/)'s authorization server. Use this proxy to secure your OAuth2 credentials.

[![Packagist](https://img.shields.io/packagist/v/npr/npr-one-backend-proxy.svg?maxAge=2592000)](https://packagist.org/packages/npr/npr-one-backend-proxy) [![Packagist](https://img.shields.io/packagist/l/npr/npr-one-backend-proxy.svg?maxAge=2592000)](https://github.com/nprdm/npr-one-backend-proxy-php/blob/master/LICENSE.md) [![Packagist](https://img.shields.io/packagist/dt/npr/npr-one-backend-proxy.svg?maxAge=2592000)](https://packagist.org/packages/npr/npr-one-backend-proxy) [![Build Status](https://travis-ci.org/nprdm/npr-one-backend-proxy-php.svg?branch=master)](https://travis-ci.org/nprdm/npr-one-backend-proxy-php) [![Coverage Status](https://coveralls.io/repos/nprdm/npr-one-backend-proxy-php/badge.svg?branch=master&service=github)](https://coveralls.io/github/nprdm/npr-one-backend-proxy-php?branch=master)


##### Table of Contents

- [Background](#background)
- [Setup](#setup)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Integration](#integration)
    - [Required Classes](#required-classes)
      - [Router](#router)
      - [ConfigProvider](#configprovider)
    - [Conditionally Required](#conditionally-required)
      - [StorageProvider](#storageprovider)
    - [Optional](#optional)
      - [EncryptionProvider](#encryptionprovider)
      - [SecureStorageProvider](#securestorageprovider)
- [Implementation Details](#implementation-details)
  - [Authorization Code Grant](#authorization-code-grant)
  - [Device Code Grant](#device-code-grant)
  - [Refresh Token Grant](#refresh-token-grant)
  - [Logout/Disconnect](#logoutdisconnect)
- [Documentation](#documentation)
- [Contributing](#contributing)
- [License](#license)


## Background

The [NPR One API](http://dev.npr.org/api/) provides a lightweight [REST](http://www.restapitutorial.com/)/[Hypermedia](https://smartbear.com/learn/api-design/what-is-hypermedia/) interface to power an [NPR One](http://www.npr.org/about/products/npr-one/) experience. To secure our API, we have implemented an authorization server based on the [OAuth 2.0 protocol](https://tools.ietf.org/html/rfc6749), a well-accepted Internet standard.

Third-party developers have two primary methods for obtaining the access tokens required by our API to interact with any of our other micro-services:

* the `authorization_code` grant
* the `device_code` grant (a custom grant based on Google's proposed spec for [OAuth2 for Limited Input Devices](https://developers.google.com/identity/protocols/OAuth2ForDevices))

The NPR One authorization server does **not** currently accept the `implicit` grant type described in the OAuth2 spec due to security concerns.

Both the `device_code` and `authorization_code` grant types require an OAuth2 `client_secret` to generate an access token. However, since the source code for web applications written in a client-side language (like Javascript) cannot be kept private, a server-side proxy is required to safely make calls to the authorization server and ensure the security of your OAuth2 credentials.

In order to make this requirement less painful for third-party developers, we are providing this PHP-based proxy as an open-source package to help you get up-and-running quickly and prevent NPR One client credentials from being compromised in public source code.


## Setup

This project is designed to be executed in a server environment with [Apache HTTP Server](https://httpd.apache.org/) or [Nginx](https://www.nginx.com/).

### Prerequisites

A recent version of [PHP](http://php.net/), equal to or greater than 5.5.0 is required.

The default [EncryptionProvider](/src/One/Providers/EncryptionProvider.php) class provided in this package relies on the [OpenSSL](http://php.net/manual/en/book.openssl.php) extension. If OpenSSL is unavailable, the consumer has the option to implement a custom EncryptionProvider class that implements our [EncryptionInterface](/src/One/Interfaces/EncryptionInterface.php). (For more information, see the [EncryptionProvider](#encryptionprovider) section.)

Usage of NPR's authorization server requires a registered developer account with the [NPR One Developer Center](http://dev.npr.org/). If you do not already have a Dev Center account, you can [register for a personal account](http://dev.npr.org/apply/) and get started immediately.

### Installation

This project is intended to be run as a sub-module (or dependency) of a larger project and should be installed using [Composer](https://getcomposer.org/) (an open-source dependency manager for PHP projects):

    [sudo] composer install npr/npr-one-backend-proxy

If you do not already have a Composer project set up, you can start one quickly with:

    composer init --require="npr/npr-one-backend-proxy" -n

### Integration

The following 2 PHP classes must be created to integrate this package into your project:

* [Router](#router)
* [ConfigProvider](#configprovider)

Additionally, if you are using the `authorization_code` grant, a [StorageProvider](#storageprovider) class will be required. Examples of each can be found in the [examples](/examples/) folder.

#### Required Classes

##### Router

Create a router which calls the relevant public methods in *either* [AuthCodeController](/src/One/Controllers/AuthCodeController.php) *or* [DeviceCodeController](/src/One/Controllers/DeviceCodeController.php), depending on which grant type will be used (`authorization_code` or `device_code`, respectively).

All consumers, regardless of grant type, **MUST** implement a route that maps to the `generateNewAccessTokenFromRefreshToken()` function in the [RefreshTokenController](/src/One/Controllers/RefreshTokenController.php) class. This route allows your server to seamlessly request a new access token when the original one has expired. If you do not implement this route, your users will automatically be logged out after 2 weeks and required to log back in to resume listening, which is not the desired user experience.

Similarly, all consumers (assuming they provide some kind of 'Logout' or 'Disconnect from NPR One' functionality) **SHOULD** implement a route that maps to the `deleteAccessAndRefreshTokens()` function in the [LogoutController](/src/One/Controllers/LogoutController.php) class. This route allows your app to ensure that all persistent data related to a logged-in state (such as access tokens and refresh tokens) are removed from NPR's authorization server, as well as ensuring that the `refresh_token` is removed from the secure storage layer. This function takes in an access token **_but_** it can also work without any input, assuming that refresh tokens are being stored persistently in the secure storage layer.

The [Router.php](/examples/Router.php) file in the [examples](/examples/) folder provides a hypothetical [Laravel](https://laravel.com/)-esque example of what this might look like. Please note, this code is intended only as an example to provide guidance on how to get started and has not been tested. This example includes code for both the `authorization_code` and `device_code` grant types, but in your actual implementation, include only the code relevant to whichever grant type you are using in your application.

##### ConfigProvider

Create a ConfigProvider class that implements our [ConfigInterface](/src/One/Interfaces/ConfigInterface.php) to power your controller classes. The ConfigProvider class will encapsulate the consumer-specific variables (your client ID and client secret) needed to power this OAuth2 proxy.

There is a sample [ConfigProvider.php](/examples/ConfigProvider.php) in the [examples](/examples/) folder to help you get started. This class does not need to be complicated and can mostly just return hard-coded strings. **However**, do not include your client secret (or your encryption salt) in any files that will appear in public repositories, as this could compromise your application. We assume that you either plan to keep your code private or you have some form of private secrets file that is not included in any public repositories or publicly-accessible locations.

#### Conditionally Required

##### StorageProvider

If you are using the `authorization_code` grant (and thereby the `AuthCodeController`), create a StorageProvider class which implements our [StorageInterface](/src/One/Interfaces/StorageInterface.php). The StorageProvider is required to validate the OAuth2 `state` param.

You will find a sample [StorageProvider.php](/examples/StorageProvider.php) file in the [examples](/examples/) folder. The example utilizes [Predis](https://github.com/nrk/predis), a PHP [Redis](http://redis.io/) client, but there are many other options, including [Memcached](http://php.net/manual/en/book.memcached.php) and [PHP sessions](http://php.net/manual/en/book.session.php). MySQL is also an option, but not recommended because it is likely to be much slower. We picked Predis for demonstration purposes because the syntax is very simple and applicable to many other storage layers.

#### Optional

##### EncryptionProvider

The Controller classes will save the refresh token and access token in a cookie by default. In order to keep those refresh tokens secure, we encrypt them before saving and decrypt them when we need to retrieve them. To make this process less cumbersome, a default [EncryptionProvider](/src/One/Providers/EncryptionProvider.php) has been provided. However, this particular EncryptionProvider relies on the [OpenSSL](http://php.net/manual/en/book.openssl.php) extension being available, which may not be an option for all developers. If OpenSSL is unavailable, or if you want to use a different method of encryption, you can use a custom encryption provider that implements our [EncryptionInterface](/src/One/Interfaces/EncryptionInterface.php).

If you choose to implement a custom encryption provider, use the [default implementation](/src/One/Providers/EncryptionProvider.php) as your example. The syntax for including your own custom encryption provider is as follows:

`authorization_code` grant type:

```php
use NPR\One\Controllers\AuthCodeController;
use Your\Package\Here\ConfigProvider;
use Your\Package\Here\EncryptionProvider;
use Your\Package\Here\StorageProvider;

$controller = (new AuthCodeController())
        ->setConfigProvider(new ConfigProvider())
        ->setStorageProvider(new StorageProvider())
        ->setEncryptionProvider(new EncryptionProvider());
```

`device_code` grant type:

```php
use NPR\One\Controllers\DeviceCodeController;
use Your\Package\Here\ConfigProvider;
use Your\Package\Here\EncryptionProvider;

$controller = (new DeviceCodeController())
        ->setConfigProvider(new ConfigProvider())
        ->setEncryptionProvider(new EncryptionProvider());
```

##### SecureStorageProvider

As explained above, encrypted cookies are used to store refresh tokens across sessions. However, cookies are not the only possible storage method: [Redis](http://redis.io/) and [Memcached](http://php.net/manual/en/book.memcached.php) are good options (as long as you have a mechanism for identifying the user across sessions, which may still require cookies). If you are considering using PHP's session storage, you may want to take a look at [PHP-Secure-Session](https://github.com/ezimuel/PHP-Secure-Session), which provides an extra layer of security through encryption.

All of the Controller classes are configured to use the [SecureCookieProvider](/src/One/Providers/SecureCookieProvider.php) as the default secure storage layer, but you can easily override this using the `setSecureStorageProvider()` function:

`authorization_code` grant type:

```php
use NPR\One\Controllers\AuthCodeController;
use Your\Package\Here\ConfigProvider;
use Your\Package\Here\SecureStorageProvider;
use Your\Package\Here\StorageProvider;

$controller = (new AuthCodeController())
        ->setConfigProvider(new ConfigProvider())
        ->setStorageProvider(new StorageProvider())
        ->setSecureStorageProvider(new SecureStorageProvider());
```

`device_code` grant type:

```php
use NPR\One\Controllers\DeviceCodeController;
use Your\Package\Here\ConfigProvider;
use Your\Package\Here\SecureStorageProvider;

$controller = (new DeviceCodeController())
        ->setConfigProvider(new ConfigProvider())
        ->setSecureStorageProvider(new SecureStorageProvider());
```

Your custom secure storage provider class needs to implement the [StorageInterface](/src/One/Interfaces/StorageInterface.php), but aside from that there are no special requirements. If you are using a tool like Redis or Memcached, you are not required to encrypt or decrypt your tokens since those systems are typically already implicitly secure. Encryption is only explicitly required by the [SecureCookieProvider](/src/One/Providers/SecureCookieProvider.php) class.


## Implementation Details

Read on for more information about how this package operates behind-the-scenes, which will help guide how your client application interacts with this backend proxy.

### Authorization Code Grant

The `authorization_code` flow has two phases, which in our case correspond to the `startAuthorizationGrant()` and `completeAuthorizationGrant()` functions in the [AuthCodeController](/src/One/Controllers/AuthCodeController.php) class:

* **Phase 1:** `startAuthorizationGrant()` constructs the query parameters that are needed for the call and appends them to `https://api.npr.org/authorization/v2/authorize`. Your router should then redirect the browser to that URL (either using a framework's built-in function such as Laravel's `redirect()->away($url)`, or otherwise just using a good old-fashioned `header("Location: $url")`).

* **Phase 2:** `completeAuthorizationGrant()` should be mapped to the `redirect_uri` that you added to your client application in the NPR One [Developer Console](http://dev.npr.org/console). This function has two primary responsibilities:
    1. Validating the `state` parameter that was generated during the `startAuthorizationGrant()` phase. This extra check ensures that your call was not intercepted by a malicious third party.
    1. Exchanging the authorization code for an actual access token using the `POST https://api.npr.org/authorization/v2/token` endpoint.

It then saves the token to an unencrypted cookie called `access_token` using our [CookieProvider](/src/One/Providers/CookieProvider.php) class. **NOTE:** it is *highly* recommended that your client application retrieves the value of the cookie, stores it somewhere locally (HTML5 [localStorage](https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage) is a good option), and then **deletes** the cookie. Otherwise, since the cookie is not encrypted it is not considered secure, and may also result in extra overhead on subsequent HTTP requests.

Note that the `completeAuthorizationGrant()` function does return an [AccessTokenModel](/src/One/Models/AccessTokenModel.php), but since the `authorization_code` grant is designed to work by redirecting the browser, it is not recommended that you actually return JSON from this endpoint. Instead, you will want to use the `getRedirectUri()` function to return to your client application and then retrieve the access token from the cookie as described above.

### Device Code Grant

The `device_code` grant similarly has two phases, but requires a little more work on the part of the client. The [DeviceCodeController](/src/One/Controllers/DeviceCodeController.php) class has two public methods: `startDeviceCodeGrant()` and `pollDeviceCodeGrant()`; each should be mapped to a unique endpoint in your router.

* **Phase 1:** The client starts off the process by calling the route that corresponds to the `startDeviceCodeGrant()` function, which calls the `POST https://api.npr.org/authorization/v2/device` endpoint and then does two things: one, it safely stores the `device_code` (value) itself, either in an encrypted cookie or using a custom secure storage provider as described [here](#securestorageprovider); and secondly, it returns *everything else* as a JSON object to the consumer. The consumer is then responsible for displaying the `user_code` and `verification_uri` on the screen.

* **Phase 2:** Next, the client is responsible for **polling** the route that corresponds to the `pollDeviceCodeGrant()` function, which calls the `POST https://api.npr.org/authorization/v2/token` endpoint with the securely-stored `device_code` and checks to see whether the user has logged in yet (returning an access token if so, and throwing an Exception if not). This polling should occur at a rate not exceeding the `interval` value in the JSON object returned by the previous call.

All device code/user code pairs will expire within the `expires_in` value in the JSON object returned by the previous call (this value represents a TTL in seconds). The client application is responsible for calling the route that corresponds to the `startDeviceCodeGrant()` function to restart this process if the user fails to log in before the device code expires.

### Refresh Token Grant

The `refresh_token` that is generated in association with every new access token should be stored securely either in an encrypted cookie or by using a custom secure storage provider as described [here](#securestorageprovider). The [RefreshTokenController](/src/One/Controllers/RefreshTokenController.php) class is thus refreshingly simple and has one method:

* `generateNewAccessTokenFromRefreshToken()` looks for this `refresh_token` in the secure storage provider and (if found) uses the `refresh_token` grant provided by the `POST https://api.npr.org/authorization/v2/token` endpoint to obtain a new access token for the user. (And in case you were wondering: yes, that call will result in a new `refresh_token` being generated, which is then saved to the secure storage layer in the exact same way.)

This method should be called when any client application that has previously obtained a valid access token suddenly receives a `401 Unauthorized` response from any of our micro-services, indicating that the access token has expired. This error should call the endpoint in your router that calls `generateNewAccessTokenFromRefreshToken()`. A new access token will be generated and returned as raw JSON (where it is up to the client application to store it securely). If a new access token could not be generated, the client may retry the call up to 2-3 times, but after that point the user should be considered logged out and prompted to log in again.

**Optional implementation:** The [AccessTokenModel](/src/One/Models/AccessTokenModel.php) and the corresponding JSON output do include an `expires_in` value (TTL in seconds) for the access token, so the client application *may* choose (but is not required) to call the route corresponding to `generateNewAccessTokenFromRefreshToken()` before the token actually expires, _or_ after it was set to expire but before another API call is attempted. Note that regardless of whether it had already expired or not, the original access token **will** be deleted immediately as part of that call.

### Logout/Disconnect

We ask all clients to help secure user data and free up unused resources in our system by implementing a form of logout functionality that will revoke the user’s previously-generated access tokens and refresh tokens through the `POST https://api.npr.org/authorization/v2/token/revoke` endpoint. The `deleteAccessAndRefreshTokens()` function in the [LogoutController](/src/One/Controllers/LogoutController.php) class will perform this task, in addition to deleting the `refresh_token` that was previously saved to an encrypted cookie or your custom [secure storage provider](#securestorageprovider). Your client application can be ignorant of whatever mechanism you're using to securely store the refresh token and safely assume that it is properly removed as part of logout.

As described in the [NPR One API Reference](http://dev.npr.org/api), the `POST https://api.npr.org/authorization/v2/token/revoke` endpoint takes in either an access token or a refresh token. By default, it's assumed to be an access token, but it will delete **both** regardless of which of the two is passed in. Therefore, the `deleteAccessAndRefreshTokens()` function _can_ take in an access token, but if none is provided, it will look for a refresh token and, if found, use that to revoke the pair of tokens. It is recommended to pass in the access token if you have it (especially for client applications developed prior to summer 2016, when refresh tokens were first introduced). If you are certain that refresh tokens have been issued for all your users and there is no chance that they have been removed by other client-side code, you can safely call `deleteAccessAndRefreshTokens()` without any parameters.

This proxy does not impose any requirements for how you set up and call your endpoints (save for what is strictly required by the OAuth 2.0 spec), so the access token parameter needed for the `deleteAccessAndRefreshTokens()` function can be obtained from a variety of sources: via a query parameter, form `POST` data, a `POST` with a JSON body, and potentially even a cookie, if that is how you are storing your access tokens client-side. The example [Router.php](/examples/Router.php) file uses a query parameter for simplicity's sake. In most cases, `POST` requests with form data or JSON bodies are preferable because they are slightly harder to intercept over insecure networks, but since the assumption here is that the access token will be revoked almost immediately, keeping the token secure is not a huge concern.


## Documentation

Further information about the public API of this package can be found in the [docs](/docs/#readme) folder.

For background information about the NPR One API and our use of OAuth2, please see the [developer guide](http://dev.npr.org/guide/) at the [NPR One Developer Center](http://dev.npr.org/). In particular, the section on the [Authorization Service](http://dev.npr.org/guide/services/authorization/) may be of interest.


## Contributing

If you're interested in contributing to this project by submitting bug reports, helping to improve the documentation, or writing actual code, please read [our contribution guidelines](/CONTRIBUTING.md).


## License

Copyright (c) 2016 NPR

Licensed under the [Apache License, Version 2.0](http://www.apache.org/licenses/License-2.0) (the “License”) with the following modification; You may not use this file except in compliance with the License as modified by the addition of Section 10, as follows:

##### 10. Additional Prohibitions

When using the Work, You may not (or allow those acting on Your behalf to):

a.	Perform any action with the intent of introducing to the Work, the NPR One API, the NPR servers or network infrastructure, or any NPR products and services any viruses, worms, defects, Trojan horses, malware or any items of a destructive or malicious nature; or obtaining unauthorized access to the NPR One API, the NPR servers or network infrastructure, or any NPR products or services;

b.	Remove, obscure or alter any NPR terms of service, including the [NPR services Terms of Use](http://www.npr.org/about-npr/179876898/terms-of-use) and the [Developer API Terms of Use](http://dev.npr.org/terms-of-use/), or any links to or notices of those terms; or

c.	Take any other action prohibited by any NPR terms of service, including the [NPR services Terms of Use](http://www.npr.org/about-npr/179876898/terms-of-use) and the [Developer API Terms of Use](http://dev.npr.org/terms-of-use/).

You may obtain a copy of the License at http://www.apache.org/licenses/License-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License with the above modification is distributed on an “AS IS” BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  See the License for the specific language governing permissions and limitations under the License.
