<?php

declare(strict_types=1);

namespace DutchdropsFlowbox5\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\CookieBundle\Services\CookieHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Shopware\Bundle\CookieBundle\Structs\CookieGroupStruct;

class Frontend implements SubscriberInterface
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @param \Shopware\Components\Plugin\ConfigReader $configReader
     * @param string $pluginDir
     * @param string $pluginName
     */
    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Front_DispatchLoopShutdown' => 'onDispatchLoopShutdown'
        ];
    }

    public function onDispatchLoopShutdown(\Enlight_Event_EventArgs $args)
    {
        $front    = $this->container->get('front');
        $request  = $front->Request();
        $response = $front->Response();
        $module   = $request->getModuleName();

        if ($module === "backend" || $module === "api") {
            return;
        }

        // Starting point is to allow Flowbox cookies
        $allow = true;

        // Let's see if user has configured which cookies to allow
        if ($request->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME)) {
            $cookiePreferences = json_decode($request->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME), true);
            $statisticsCookies = array();

            if (isset($cookiePreferences['groups'][CookieGroupStruct::STATISTICS]['cookies'])) {
                $statisticsCookies = $cookiePreferences['groups'][CookieGroupStruct::STATISTICS]['cookies'];
            }

            foreach ($statisticsCookies as $statisticsCookie) {

                if ($statisticsCookie['name'] == 'flowbox' && $statisticsCookie['active']) {
                    $allow = true;
                } elseif ($statisticsCookie['name'] == 'flowbox' && !$statisticsCookie['active']) {
                    $allow = false;
                }
            }
        }

        // Check if all cookies are allowed with the 'accept all' button
        if ($request->getCookie('allowCookie')) {
            $allow = true;
        }

        // Cookie declined always overrules the others
        if ($request->getCookie('cookieDeclined')) {
            $allow = false;
        }

        $requestCookies          = $request->cookies->all();
        $cookieBasePath          = $request->getBasePath();
        $cookiePath              = $cookieBasePath . '/';
        $currentPath             = $cookieBasePath . $request->getPathInfo();
        $currentPathWithoutSlash = '/' . trim($currentPath, '/');

        foreach ($requestCookies as $cookieKey => $cookieName) {

            if ($allow === false && ($cookieKey === '_flowbox' || $cookieKey === '_flowbox')) {

                // Remove flowbox cookie
                $domain = $request->getHttpHost();

                $response->headers->setCookie(new Cookie($cookieKey, null, 0, '/', $domain));
                $response->headers->setCookie(new Cookie($cookieKey, null, 0, $cookieBasePath, $domain));
                $response->headers->setCookie(new Cookie($cookieKey, null, 0, $cookiePath, $domain));
                $response->headers->setCookie(new Cookie($cookieKey, null, 0, $currentPath, $domain));
                $response->headers->setCookie(new Cookie($cookieKey, null, 0, $currentPathWithoutSlash, $domain));
                $response->headers->setCookie(new Cookie($cookieKey, null, 0, $request->getBaseUrl(), $domain));
                $response->headers->setCookie(new Cookie($cookieKey, null, 0, $cookieBasePath . $request->getBaseUrl(), $domain));
            }
        }
    }
}