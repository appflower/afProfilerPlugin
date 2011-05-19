<?php
/**
 * This specialized version of afExecutionFilter measures time spent on request processing
 * That data is then accessed by one of afProfiler data collectors
 *
 * @todo afExecutionFilter::executeAction() should be refactored towards DRY principle
 **/
class afProfilerExecutionFilter extends afExecutionFilter
{
    protected function executeAction($actionInstance)
    {
        $actionTimer = sfTimerManager::getTimer('afAction');
        if($this->isExportRequest($actionInstance)) {
            $actionInstance->isPageComponent = true;
        } elseif($this->isFirstPageRequest($actionInstance)) {
            $request = $actionInstance->getRequest();
            if($request->getAttribute('af_first_page_request') !== true) {
                $request->setAttribute('af_first_page_request', true);
                $actionInstance->forward('appFlower', 'firstPage');
            }
        }

        $actionInstance->preExecute();
        $viewName = $actionInstance->execute($this->context->getRequest());
        $actionInstance->postExecute();
        $actionTimer->addTime();

        $viewName = is_null($viewName) ? sfView::SUCCESS : $viewName;
        $viewName = $this->interpretView($actionInstance, $viewName);
        return is_null($viewName) ? sfView::SUCCESS : $viewName;
    }
    
    /**
     * @return afRenderingRouter 
     */
    protected function createRenderingRouter(sfAction $actionInstance)
    {
        return new afProfilerRenderingRouter($actionInstance);
    }
}