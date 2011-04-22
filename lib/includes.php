<?php

/**
 * I did not wanted to spent time on custom autoloder for sf2 files so I went easy path here :)
 *
 * In future when we'll be switching to sf2 we should use "official" standard for using namespaces
 * and organizing files
 * http://groups.google.com/group/php-standards/web/psr-0-final-proposal
 */

$baseDir = dirname(__FILE__).'/vendor/symfony2/';
require_once "${baseDir}HttpKernel/HttpKernelInterface.php";
require_once "${baseDir}HttpKernel/HttpKernel.php";
require_once "${baseDir}HttpKernel/Profiler/Profiler.php";
require_once "${baseDir}HttpKernel/Profiler/ProfilerStorageInterface.php";
require_once "${baseDir}HttpKernel/Profiler/PdoProfilerStorage.php";
require_once "${baseDir}HttpKernel/Profiler/SqliteProfilerStorage.php";
require_once "${baseDir}HttpKernel/DataCollector/DataCollectorInterface.php";
require_once "${baseDir}HttpKernel/DataCollector/DataCollector.php";
require_once "${baseDir}HttpKernel/DataCollector/MemoryDataCollector.php";
require_once "${baseDir}HttpKernel/DataCollector/RequestDataCollector.php";
require_once "${baseDir}HttpFoundation/ParameterBag.php";
require_once "${baseDir}HttpFoundation/FileBag.php";
require_once "${baseDir}HttpFoundation/ServerBag.php";
require_once "${baseDir}HttpFoundation/HeaderBag.php";
require_once "${baseDir}HttpFoundation/Request.php";
require_once "${baseDir}HttpFoundation/Response.php";
require_once "${baseDir}HttpFoundation/ResponseHeaderBag.php";
require_once "${baseDir}HttpFoundation/Session.php";
require_once "${baseDir}HttpFoundation/SessionStorage/SessionStorageInterface.php";
require_once "${baseDir}HttpFoundation/SessionStorage/NativeSessionStorage.php";
require_once "${baseDir}HttpFoundation/SessionStorage/ArraySessionStorage.php";

require_once dirname(__FILE__).'/dataCollector/PropelDataCollector.php';