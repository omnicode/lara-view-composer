<?php
namespace LaraViewComposer\ViewComposer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use LaraRepo\Criteria\Where\WhereCriteria;
class ListComposer
{
    /**
     * @var
     */
    protected $repository;
    
    /**
     * @var null
     */
    protected $listable = null;
    
    /**
     * @var bool
     */
    protected $isParentNull = false;
    
    /**
     * @var null
     */
    protected $status = true;
    
    /**
     * @var bool
     */
    protected $isFindCurrentId = false;
    
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if (!is_array($this->repository)) {
            $this->repository = [$this->repository];
        }
        
        $this->listable = (array) $this->listable;
        $this->status = (array) $this->status;
        $this->isFindCurrentId = (array) $this->isFindCurrentId;
        $this->isParentNull = (array) $this->isParentNull;
        
        foreach ($this->repository as $index => $repository) {
            $listable = (isset($this->listable[$index])) ? $this->listable[$index] : null;
            $isParentNull = (isset($this->isParentNull[$index])) ? $this->isParentNull[$index] : false;
            $status = (isset($this->status[$index])) ? $this->status[$index] : true;
            $isFindCurrentId = (isset($this->isFindCurrentId[$index])) ? $this->isFindCurrentId[$index] : false;
            
            if (!empty($isParentNull)) {
                $repository->pushCriteria(new WhereCriteria('parent_id', null));
            }
            
            if (isset($view->getData()['item']->id) && !$isFindCurrentId) {
                $repository->pushCriteria(new WhereCriteria('id', $view->getData()['item']->id, '!='));
            }
            
            $items = $repository->findList($status, $listable);
            $view->with($repository->getTable(), $items);
        }
    }
}
