<?php

use Illuminate\Http\Response;
use NPR\One\Controllers\AuthCodeController;
use NPR\One\Controllers\DeviceCodeController;
use NPR\One\Controllers\LogoutController;
use NPR\One\Controllers\RefreshTokenController;
use NPR\One\Exceptions\ApiException;
use Your\Package\Here\ConfigProvider;
use Your\Package\Here\StorageProvider;


/**
 * This route corresponds to Phase 1 of the Authorization Code grant.
 * @see https://github.com/npr/npr-one-backend-proxy-php#authorization-code-grant
 *
 * If you are using the Device Code grant, you do not need to implement this route.
 */
Route::get('/', function ()
{
    $controller = (new AuthCodeController())
        ->setConfigProvider(new ConfigProvider())
        ->setStorageProvider(new StorageProvider());

    try
    {
        $url = $controller->startAuthorizationGrant([
            'identity.readonly',
            'identity.write',
            'listening.readonly',
            'listening.write',
            'localactivation'
        ]);
        return redirect()->away($url); // in this case, all is well and we're redirecting to the login page on npr.org
    }
    catch (\Exception $e)
    {
        Log::error("During OAuth login, npr-one-backend-proxy encountered an error: {$e->getMessage()}");
    }

    return redirect()->away($controller->getRedirectUri()); // something went wrong; all we can do is redirect back to the app
    // alternatively, you could create some kind of Error page saying "Something went wrong. Click here to go back to the app." (to make it more explicit to users)
});

/**
 * This route corresponds to Phase 2 of the Authorization Code grant.
 * @see https://github.com/npr/npr-one-backend-proxy-php#authorization-code-grant
 *
 * It is important to note that the path corresponding to this route should match EXACTLY what you registered as
 * your `redirect_uri` in the NPR One Developer Center.
 *
 * If you are using the Device Code grant, you do not need to implement this route.
 */
Route::get('callback', function ()
{
    $controller = (new AuthCodeController())
        ->setConfigProvider(new ConfigProvider())
        ->setStorageProvider(new StorageProvider());

    $error = $_GET['error'];
    $message = $_GET['message'];

    try
    {
        if (!empty($error))
        {
            if ($error !== 'denied')
            {
                Log::error("During OAuth login, npr-one-backend-proxy encountered an error: $error, message: $message");
            }
            // if $error === 'denied' - user chose to deny the login request, no need to log it (not a "true" error state).
        }
        else
        {
            $authorizationCode = $_GET['code'];
            $state = $_GET['state'];
            if (empty($authorizationCode) || empty($state))
            {
                Log::error('During OAuth login, npr-one-backend-proxy encountered an error: Either authorization code or state not set.');
            }
            else
            {
                $controller->completeAuthorizationGrant($authorizationCode, $state); // if this doesn't throw any exceptions, then we're good
            }
        }
    }
    catch (\Exception $e)
    {
        Log::error("During OAuth login, npr-one-backend-proxy encountered an error: {$e->getMessage()}");
    }

    return redirect()->away($controller->getRedirectUri()); // no matter whether we're OK or we're in an error state, we redirect back to the app
    // again, you may want to consider creating a "Something went wrong" page for error states, but that's beyond the scope of this example
});

/**
 * This route corresponds to Phase 1 of the Device Code grant.
 * @see https://github.com/npr/npr-one-backend-proxy-php#device-code-grant
 *
 * If you are using the Authorization Code grant, you do not need to implement this route.
 */
Route::post('device', function ()
{
    $controller = (new DeviceCodeController())
        ->setConfigProvider(new ConfigProvider());
    $statusCode = 201;

    try
    {
        $data = $controller->startDeviceCodeGrant([
            'identity.readonly',
            'identity.write',
            'listening.readonly',
            'listening.write',
            'localactivation'
        ]);
    }
    catch (ApiException $e)
    {
        $data = $e->getMessage();
        $statusCode = $e->getStatusCode();
    }
    catch (\Exception $e)
    {
        $data = $e->getMessage();
        $statusCode = 500;
    }

    return addCORSHeaders(response())->json($data)->setStatusCode($statusCode); // this route is meant to be called with AJAX/Fetch, so we're returning JSON
});

/**
 * This route corresponds to Phase 2 of the Device Code grant.
 * @see https://github.com/npr/npr-one-backend-proxy-php#device-code-grant
 *
 * If you are using the Authorization Code grant, you do not need to implement this route.
 */
Route::post('device/poll', function ()
{
    $controller = (new DeviceCodeController())
        ->setConfigProvider(new ConfigProvider());
    $statusCode = 201;

    try
    {
        $data = $controller->pollDeviceCodeGrant();
    }
    catch (ApiException $e)
    {
        $data = !empty($e->getBody()) ? $e->getBody() : $e->getMessage();
        $statusCode = $e->getStatusCode();
    }
    catch (\Exception $e)
    {
        $data = $e->getMessage();
        $statusCode = 500;
    }

    return addCORSHeaders(response())->json($data)->setStatusCode($statusCode); // this route is meant to be called with AJAX/Fetch, so we're returning JSON
});

/**
 * This route corresponds to the Refresh Token grant.
 * @see https://github.com/npr/npr-one-backend-proxy-php#refresh-token-grant
 *
 * EVERYONE, regardless of which grant you use to log in your users, must implement this route.
 */
Route::post('refresh', function ()
{
    $controller = (new RefreshTokenController())
        ->setConfigProvider(new ConfigProvider());
    $statusCode = 201;

    try
    {
        $data = $controller->generateNewAccessTokenFromRefreshToken();
    }
    catch (ApiException $e)
    {
        $data = $e->getMessage();
        $statusCode = $e->getStatusCode();
    }
    catch (\Exception $e)
    {
        $data = $e->getMessage();
        $statusCode = 500;
    }

    return addCORSHeaders(response())->json($data)->setStatusCode($statusCode); // this route is meant to be called with AJAX/Fetch, so we're returning JSON
});

Route::post('logout', function ()
{
    $token = $_GET['token'];

    $controller = (new LogoutController())
        ->setConfigProvider(new ConfigProvider());
    $statusCode = 200;

    try
    {
        $controller->deleteAccessAndRefreshTokens($token);
        $data = ''; // there is nothing to return in the case of success; an empty string should suffice
    }
    catch (ApiException $e)
    {
        $data = $e->getMessage();
        $statusCode = $e->getStatusCode();
    }
    catch (\Exception $e)
    {
        $data = $e->getMessage();
        $statusCode = 500;
    }

    return addCORSHeaders(response())->json($data)->setStatusCode($statusCode); // this route is meant to be called with AJAX/Fetch, so we're returning JSON
});


/**
 * This helper function sets the CORS headers required to use these endpoints in a frontend Javascript-based application.
 *
 * NOTE: It is HIGHLY recommended that you use a CORS middleware which is usually provided by your PHP framework
 * (or available as an optional plugin); however, in the (unlikely) event that no such middleware is available,
 * we have included here the headers that need to be set in order for the proxy to work with the secure cookie-based
 * refresh tokens.
 *
 * @param Response $response
 * @return Response
 */
function addCORSHeaders(Response $response)
{
    $response->header('Access-Control-Allow-Origin', 'one.example.com'); // IMPORTANT!! you cannot use a wildcard ('*') here; you MUST include a host
    $response->header('Access-Control-Allow-Credentials', 'true'); // this is the reason why you MUST include a host; you cannot use a wildcard with Allow-Credentials
    $response->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS'); // if you are using methods other than POST and GET, update accordingly
    $response->header('Access-Control-Allow-Headers', join(', ', [
        'origin', 'accept', 'content-type', 'authorization',
        'x-http-method-override', 'x-pingother', 'x-requested-with',
        'if-match', 'if-modified-since', 'if-none-match', 'if-unmodified-since'
    ]));
    $response->header('Access-Control-Expose-Headers', join(', ', [
        'tag', 'link',
        'X-RateLimit-Limit', 'X-RateLimit-Remaining', 'X-RateLimit-Reset',
        'X-OAuth-Scopes', 'X-Accepted-OAuth-Scopes'
    ]));
    return $response;
}
