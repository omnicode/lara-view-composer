<?php
namespace LaraViewComposer\ViewComposer;

use Illuminate\View\View;

class ListComposer
{
    /**
     * @var array
     */
    protected $repository;

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if(!is_array($this->repository)) {
            $this->repository = [$this->repository];
        }
        
        foreach($this->repository as $repository) {
            $items = $repository->findList(true);
            $view->with($repository->getTable(), $items);
        }
    }

}
