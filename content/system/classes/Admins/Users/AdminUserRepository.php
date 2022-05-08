<?php


namespace Ecjia\System\Admins\Users;


use Ecjia\System\Frameworks\Contracts\AdminUserRepositoryInterface;
use RC_Hook;
use Royalcms\Component\Repository\Repositories\AbstractRepository;
use Royalcms\Component\Support\Traits\Macroable;

class AdminUserRepository extends AbstractRepository implements AdminUserRepositoryInterface
{

    use Macroable;

    protected $model = 'Ecjia\System\Admins\Users\AdminUserModel';

    public function __construct()
    {
        $this->model = RC_Hook::apply_filters('ecjia_admin_user_model', $this->model);

        parent::__construct();

    }

    public static function model()
    {
        return royalcms(AdminUserRepositoryInterface::class)->query();
    }

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $this->newQuery();
        return $this->query;
    }

}