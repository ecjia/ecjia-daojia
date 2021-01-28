<?php


namespace Ecjia\App\Rpc\Lists;


use ecjia;
use Ecjia\App\Rpc\Repositories\DefaultRpcAccountRepository;
use ecjia_page;
use RC_Time;

class RpcAccountList
{

    public function __invoke()
    {
        $filter              = array();
        $keywords  = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        if (!empty($keywords)) {
            $filter['keywords'] = function ($query) use ($keywords) {
                return $query->where('name', 'like', '%' . mysql_like_quote($keywords) . '%');
            };
        }

        $repository = new DefaultRpcAccountRepository();

        foreach ($filter as $closure) {
            $repository->addScopeQuery($closure);
        }

        $count = $repository->count();
        $filter['record_count'] = $count;
        $page                   = new ecjia_page($count, $repository->getModel()->getPerPage(), 5);

        $data = $repository->orderBy('sort', 'asc')
                ->orderBy('add_time', 'desc')
                ->paginate();

        $data = $data->map(function ($item) {
            $item['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $item['add_gmtime']);
            return $item;
        });

        return array('item' => $data, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }

}