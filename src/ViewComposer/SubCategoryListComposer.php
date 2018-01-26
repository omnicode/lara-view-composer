<?php
namespace LaraViewComposer\ViewComposer;

use Illuminate\View\View;
use LaraRepo\Criteria\Where\WhereCriteria;

class SubCategoryListComposer
{

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if (!empty($this->isParentNull)) {
            $this->repository->pushCriteria(new WhereCriteria('parent_id', NULL));
        }

        if(isset($view->getData()['id'])) {
            $this->repository->pushCriteria(new WhereCriteria('id', $view->getData()['id'], '!='));
        }

        $items = $this->repository->findList(true);
        $view->with($this->repository->getTable(), $items);
    }

}