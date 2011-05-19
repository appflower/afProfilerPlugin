<?php
/**
 * WidgetDataCollector
 *
 * This one collects informations about time spent for each part of widget request processing
 *
 * @todo:
 * afRender timer can be unavailable at some cases
 * This is caused by LayoutExt class being used in actions directly - such actions code needs to be corrected for afRender timer
 *
 * @author Łukasz Wojciechowski <luwo@appflower.com>
 */
class WidgetDataCollector extends Symfony\Component\HttpKernel\DataCollector\DataCollector
{
    public function collect(Symfony\Component\HttpFoundation\Request $request, Symfony\Component\HttpFoundation\Response $response, \Exception $exception = null)
    {
        $timers = sfTimerManager::getTimers();
        $this->data = array(
            'action' => @$timers['afAction'] ? round($timers['afAction']->getElapsedTime(), 2) : null,
            'read' => @$timers['afRead'] ? round($timers['afRead']->getElapsedTime(), 2) : null,
            'wrap' => @$timers['afWrap'] ? round($timers['afWrap']->getElapsedTime(), 2) : null,
            'render' => @$timers['afRender'] ? round($timers['afRender']->getElapsedTime(), 2) : null,
        );
    }

    function getActionTime()
    {
        return number_format($this->data['action']*1000, 0, '.', '');
    }

    function getRenderTime()
    {
        return number_format($this->data['render']*1000, 0, '.', '');
    }
    
    function getReadTime()
    {
        return number_format($this->data['read']*1000, 0, '.', '');
    }
    
    function getWrapTime()
    {
        return number_format($this->data['wrap']*1000, 0, '.', '');
    }

    public function getName()
    {
        return 'widget';
    }
}
