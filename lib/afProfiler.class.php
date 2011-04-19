<?php
require_once __DIR__.'/includes.php';

use Symfony\Component\HttpKernel as HttpKernel;
use Symfony\Component\HttpFoundation as HttpFoundation;

/**
 * We are extending Profiler class to translate sf1.4 request and response objects to
 * their representative objects in sf2 world
 */
class afProfiler extends HttpKernel\Profiler\Profiler
{
    static function create()
    {
        $dsn = 'sqlite:'.sfConfig::get('sf_cache_dir').'/profiler.db';
        $profilerStorage = new HttpKernel\Profiler\SqliteProfilerStorage($dsn);
        $profiler = new afProfiler($profilerStorage);

        $memoryDataCollector = new HttpKernel\DataCollector\MemoryDataCollector;
        $profiler->add($memoryDataCollector);
        $requestDataCollector = new HttpKernel\DataCollector\RequestDataCollector;
        $profiler->add($requestDataCollector);
        $propelDataCollector = new PropelDataCollector;
        $profiler->add($propelDataCollector);

        return $profiler;
    }

    public function collectFromContext(sfContext $context = null) {
        if (!$context) {
            $context = sfContext::getInstance();
        }
        $this->collect(
            $this->getSf2Request($context->getRequest()),
            $this->getSf2Response($context->getResponse())
        );
    }

    public function sendHeaders()
    {
        header("X-Debug-Token: ".$this->getToken());
    }

    private function getSf2Request(sfWebRequest $request)
    {
        $sf2Request = new HttpFoundation\Request(
            $request->getGetParameters(),
            $request->getPostParameters(),
            array(),
            $_COOKIE,
            $request->getFiles(),
            $_SERVER
        );

        $sessionStorage = new HttpFoundation\SessionStorage\ArraySessionStorage();
        foreach (sfContext::getInstance()->getUser()->getAttributeHolder()->getAll() as $key => $value) {
            $sessionStorage->write($key, $value);
        }
        $session = new HttpFoundation\Session($sessionStorage);
        $sf2Request->setSession($session);
        return $sf2Request;
    }

    private function getSf2Response(sfWebResponse $response)
    {
        return new HttpFoundation\Response(
            $response->getContent(),
            $response->getStatusCode(),
            $response->getHttpHeaders()
        );

    }
}