<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Symfony\Component\HttpFoundation\Response;

class XSS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        if(isset($input['location_map']) && !empty($input['location_map'])){
            return $next($request);
        }

        $skipFields = [];

        if ($request->routeIs('email-template.update')) {
            $skipFields = ['email_content', 'email_content_data'];
        }

        array_walk_recursive($input, function (&$value, $key) use ($skipFields) {
            if (in_array($key, $skipFields, true)) {
                return;
            }

            $value = (is_null($value)) ? null : Purifier::clean(html_entity_decode($value));
        });

        $request->merge($input);

        $input = $request->all();
        array_walk_recursive($input, function (&$input) {
            $input = (is_null($input)) ? null : str_replace('&amp;', '&', $input);
        });
        $request->merge($input);

        return $next($request);
    }
}
