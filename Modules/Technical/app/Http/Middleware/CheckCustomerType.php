<?php

namespace Modules\Technical\app\Http\Middleware;

use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;

class CheckCustomerType
{
    use HttpResponse;
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->type == 'customer'){
            return $next($request);
        }
        return $this->validationErrorsResponse(translate_word('cannot_apply'));
    }
}
