<?php
//
//
//namespace App\Filters;
//
//
//use App\User;
//use Illuminate\Http\Request;
//class ThreadFilters
//{
//    /**
//     * @var Request
//     */
//    protected $request;
//
//    /**
//     * ThreadFilters constructor.
//     *
//     * @param Request $request
//     */
//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }
//
//    /**
//     * Apply our filters to the builder
//     * @param $queryBuilder
//     * @return mixed
//     */
//    public function apply($queryBuilder)
//    {
//        if (! $username = $this->request->by) return $queryBuilder;
//
//        $user = User::where('name', $username)->firstOrFail();
//
//        return $queryBuilder->where('user_id', $user->id);
//    }
//}