<?php
require_once dirname(__DIR__).'/afProfiler.class.php';

/**
 * A filter that initates profiler and collects profiling data
 *
 * We need to plug profiler using symfony filters to let profiler start collecting
 * data as soon as possible.
 */
class afProfilerFilter extends sfFilter
{
	public function execute (sfFilterChain $filterChain)
	{
        $profiler = afProfiler::create();
        $this->getContext()->set('profiler', $profiler);

        $filterChain->execute();

        $profiler->collectFromContext();
    }
}