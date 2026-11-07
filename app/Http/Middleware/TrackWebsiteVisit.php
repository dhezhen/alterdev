<?php

namespace App\Http\Middleware;

use App\Models\WebsiteVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackWebsiteVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $userAgent = strtolower($request->userAgent() ?? '');
        $isCrawler = preg_match('/bot|crawler|spider|slurp|preview/i', $userAgent) === 1;

        if (
            $request->isMethod('GET')
            && $response->isSuccessful()
            && ! $request->routeIs('sitemap')
            && ! $request->user()
            && ! $isCrawler
        ) {
            $date = now()->toDateString();
            $visitorHash = hash_hmac(
                'sha256',
                $date.'|'.$request->session()->getId(),
                (string) config('app.key'),
            );

            WebsiteVisit::query()->insertOrIgnore([
                'visit_date' => $date,
                'visitor_hash' => $visitorHash,
            ]);
        }

        return $response;
    }
}
