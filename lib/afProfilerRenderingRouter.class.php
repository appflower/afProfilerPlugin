<?php

class afProfilerRenderingRouter extends afRenderingRouter
{
    public function render() {
        $timer = sfTimerManager::getTimer('afRead');
        $doc = $this->readWidgetConfig($this->module, $this->action);
        $view = $this->wrapDoc($doc, $this->actionVars);
        $timer->addTime();
        
        $timer = sfTimerManager::getTimer('afRender');
        $return = $this->renderContent($view);
        $timer->addTime();
        
        return $return;
    }
}
