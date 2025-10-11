<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLeaveBalance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $totalLeave = (int) Leave::where('user_id', Auth::user()->id)
            ->where('request_status', 'approved')
            ->sum('leave_period') / 8;
        $annualLeaveBalance = (int) Auth::user()->overwork_allowance;

        if ($totalLeave >= floor($annualLeaveBalance)) {
            return redirect()->route('info.account-suspended')->withErrors(['Your account has been suspended. Please contact support.']);
        }

        return $next($request);
    }
}
